<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\FlaskRecommendationClient;

/**
 * RekomendasiAPI.php
 * ==================
 * Controller API untuk sistem rekomendasi menu berbasis waktu.
 * Memanggil script Python ML dan mengembalikan hasil dalam format JSON.
 *
 * Endpoint:
 *   GET /api/rekomendasi          → rekomendasi berdasarkan jam sekarang
 *   GET /api/rekomendasi/{jam}    → rekomendasi berdasarkan jam tertentu (0-23)
 *   GET /api/rekomendasi/jam/{jam}
 *
 * Cara install Python & dependencies:
 *   pip install scikit-learn pandas numpy joblib flask flask-cors
 */
class RekomendasiAPI extends BaseController
{
    /** Simpan satu impression secara best-effort; kegagalan tidak memutus rekomendasi. */
    private function logRecommendation(array $data): ?int
    {
        try {
            $ids = [];
            $collect = static function (array $items) use (&$collect, &$ids): void {
                foreach ($items as $item) {
                    if (($item['tipe'] ?? '') === 'kelompok') {
                        $collect($item['anggota'] ?? []);
                    } elseif (!empty($item['id_produk'])) {
                        $ids[] = (string) $item['id_produk'];
                    }
                }
            };
            $collect($data['rekomendasi'] ?? []);
            $ids = array_values(array_unique($ids));
            if ($ids === []) {
                return null;
            }

            $db = \Config\Database::connect();
            $inserted = $db->table('recommendation_logs')->insert([
                'jam' => max(0, min(23, (int) ($data['jam'] ?? date('G')))),
                'source' => substr((string) ($data['source'] ?? 'unknown'), 0, 64),
                'menu_ditampilkan' => json_encode($ids, JSON_UNESCAPED_SLASHES),
            ]);
            if (!$inserted) {
                return null;
            }
            return (int) $db->insertID() ?: null;
        } catch (\Throwable $e) {
            log_message('warning', 'Pencatatan impression rekomendasi dilewati: {message}', ['message' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Ambil rekomendasi menu berdasarkan jam real-time atau query parameter (?jam=X).
     */
    public function index()
    {
        $jamParam = $this->request->getGet('jam');
        if ($jamParam !== null && $jamParam !== '') {
            $jam = (int) $jamParam;
            if ($jam < 0 || $jam > 23) {
                return $this->response
                    ->setJSON([
                        'status'  => 'error',
                        'message' => 'Jam tidak valid. Gunakan angka 0-23.',
                    ])
                    ->setStatusCode(400);
            }
            return $this->getRekomendasiByJam($jam);
        }

        return $this->getRekomendasiByJam(null);
    }

    /**
     * Ambil rekomendasi menu berdasarkan jam tertentu.
     *
     * @param int|null $jam  Jam 0-23, null = jam sekarang
     */
    public function byJam($jam = null)
    {
        $jam = ($jam !== null) ? (int) $jam : null;

        if ($jam !== null && ($jam < 0 || $jam > 23)) {
            return $this->response
                ->setJSON([
                    'status'  => 'error',
                    'message' => 'Jam tidak valid. Gunakan angka 0-23.',
                ])
                ->setStatusCode(400);
        }

        return $this->getRekomendasiByJam($jam);
    }

    /**
     * Enrich items dengan field gambar (URL lengkap) dan stok dari tabel products.
     */
    private function enrichGambar(array $items): array
    {
        $db = \Config\Database::connect();
        foreach ($items as &$it) {
            if (($it['tipe'] ?? 'menu') === 'kelompok' && !empty($it['anggota'])) {
                $it['anggota'] = $this->enrichGambar($it['anggota']);
                $first = $it['anggota'][0];
                foreach (['id_produk','nama','kategori','harga','deskripsi','gambar','stok','varian_suhu','tambahan_harga_es','suhu_tetap','punya_opsi','label_opsi','options'] as $key) {
                    $it[$key] = $first[$key] ?? ($it[$key] ?? null);
                }
                continue;
            }

            $row = $db->table('products')
                ->select('nama, kategori, harga, deskripsi, gambar, stok, varian_suhu, tambahan_harga_es, suhu_tetap, punya_opsi, label_opsi')
                ->where('id_produk', $it['id_produk'] ?? '')
                ->get()->getRowArray();

            if ($row) {
                $it['nama'] = $row['nama'];
                $it['kategori'] = $row['kategori'];
                $it['harga'] = (float) $row['harga'];
                $it['deskripsi'] = $row['deskripsi'] ?? '';
                $it['varian_suhu'] = (int) $row['varian_suhu'];
                $it['tambahan_harga_es'] = (float) $row['tambahan_harga_es'];
                $it['suhu_tetap'] = $row['suhu_tetap'];
                $it['punya_opsi'] = (int) $row['punya_opsi'];
                $it['label_opsi'] = $row['label_opsi'];
                $it['options'] = $row['punya_opsi']
                    ? $db->table('product_options')
                        ->where('id_produk', $it['id_produk'])
                        ->where('aktif', 1)
                        ->orderBy('urutan', 'ASC')
                        ->get()
                        ->getResultArray()
                    : [];
            }
            $it['gambar'] = !empty($row['gambar'])
                ? base_url('uploads/' . $row['gambar'])
                : base_url('assets/no-image.svg');
            $it['stok'] = isset($row['stok']) ? (int) $row['stok'] : null;
        }
        unset($it);
        return $items;
    }

    private function formatKategoriRekomendasi(array $items, ?string $segmen): array
    {
        $produkKopi = ['PRD0000023','PRD0000024','PRD0000025','PRD0000031','PRD0000032','PRD0000033','PRD0000034','PRD0000035','PRD0000036','PRD0000037','PRD0000038','PRD0000039','PRD0000040','PRD0000041'];
        $produkPanas = ['PRD0000031','PRD0000032','PRD0000033','PRD0000034','PRD0000035','PRD0000036'];
        $produkDingin = ['PRD0000037','PRD0000038','PRD0000039','PRD0000040','PRD0000041','PRD0000042'];
        $hasil = [];

        foreach ($items as $item) {
            if (($item['tipe'] ?? 'menu') === 'kelompok') {
                $item['anggota'] = $this->formatKategoriRekomendasi($item['anggota'] ?? [], $segmen);
                if ($item['anggota'] === []) {
                    continue;
                }
                $hasil[] = $item;
                continue;
            }

            $id = $item['id_produk'] ?? '';
            if (in_array($id, ['PRD0000024', 'PRD0000025'], true)) {
                continue;
            }

            $kategori = strtolower((string) ($item['kategori'] ?? ''));
            $isMinuman = str_contains($kategori, 'minuman') || str_contains($kategori, 'kopi') || str_contains($kategori, 'nutrisari');
            if ($isMinuman) {
                $suhu = $item['suhu_tetap'] ?? null;
                if ($suhu === 'dingin') {
                    $suhu = 'es';
                }
                if (!$suhu) {
                    $suhu = in_array($id, $produkPanas, true) ? 'panas' : (in_array($id, $produkDingin, true) ? 'es' : ($segmen === 'siang' || $segmen === 'malam' ? 'es' : 'panas'));
                }
                $item['suhu_default'] = $suhu;
                $labelSuhu = $suhu === 'es' || $suhu === 'dingin' ? 'Minuman Dingin' : 'Minuman Panas';
                $labelJenis = str_contains($kategori, 'non kopi')
                    ? 'Non Kopi'
                    : (in_array($id, $produkKopi, true) || str_contains($kategori, 'kopi') ? 'Kopi' : 'Non Kopi');
                $item['kategori_rekomendasi'] = $labelSuhu . ' · ' . $labelJenis;
            }

            $hasil[] = $item;
        }

        return $hasil;
    }

    /**
     * Core: request ke Flask API server (localhost:5001) dan return JSON.
     */
    private function getRekomendasiByJam($jam)
    {
        $hasil = (new FlaskRecommendationClient())->fetch($jam);
        if ($hasil === null) {
            // Fallback: gunakan rule-based jika Flask tidak tersedia
            return $this->fallbackRuleBased($jam);
        }

        $kepercayaan = $hasil['data']['kepercayaan'] ?? null;
        if (is_numeric($kepercayaan)
            && $kepercayaan < \Config\Recommendation::LOW_CONFIDENCE_THRESHOLD) {
            return $this->fallbackRuleBased($jam, 'rule-based-jam-sepi');
        }

        if (isset($hasil['data']['rekomendasi']) && is_array($hasil['data']['rekomendasi'])) {
            $hasil['data']['rekomendasi'] = $this->enrichGambar($hasil['data']['rekomendasi']);
            $hasil['data']['rekomendasi'] = $this->formatKategoriRekomendasi($hasil['data']['rekomendasi'], $hasil['data']['segmen'] ?? null);
        }

        $hasil['data']['log_id'] = $this->logRecommendation($hasil['data']);

        return $this->response->setJSON($hasil);
    }

    /**
     * Fallback rule-based jika Python/model tidak tersedia.
     * Tetap memberikan rekomendasi tanpa ML.
     */
    private function fallbackRuleBased($jam = null, string $source = 'rule-based')
    {
        $now    = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));
        $jam    = $jam ?? (int) $now->format('H');
        $hari   = (int) $now->format('N') - 1; // 0=Senin
        $namaHari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'][$hari];

        $slotMenu = fn($rank, $id, $suhu = null) => ['peringkat' => $rank, 'tipe' => 'menu', 'id_produk' => $id, 'suhu_default' => $suhu];
        $slotKelompok = function ($rank, $nama, $ids, $suhu = null) {
            $idKopi = ['PRD0000023','PRD0000024','PRD0000025','PRD0000031','PRD0000032','PRD0000033','PRD0000034','PRD0000035','PRD0000036','PRD0000037','PRD0000038','PRD0000039','PRD0000040','PRD0000041'];
            $isMinuman = str_contains(strtolower($nama), 'minuman') || str_contains(strtolower($nama), 'kopi') || str_contains(strtolower($nama), 'segar');
            return [
                'peringkat' => $rank, 'tipe' => 'kelompok', 'nama_kelompok' => $nama, 'nama' => $nama,
                'anggota' => array_map(fn($id) => [
                    'id_produk' => $id,
                    'subkategori' => $isMinuman ? (in_array($id, $idKopi, true) ? 'Kopi' : 'Non Kopi') : null,
                ], $ids),
                'suhu_default' => $suhu,
            ];
        };

        if ($jam >= 5 && $jam <= 10) {
            $segmen = 'pagi'; $suhuDefault = 'panas'; $rentang = '05.00-10.59';
            $rekomendasi = [
                $slotMenu(1, 'PRD0000026', 'panas'), $slotMenu(2, 'PRD0000027', 'panas'),
                $slotMenu(3, 'PRD0000028', 'panas'), $slotMenu(4, 'PRD0000029', 'panas'),
                $slotKelompok(5, 'Minuman Panas', ['PRD0000031','PRD0000032','PRD0000033','PRD0000034','PRD0000035','PRD0000036','PRD0000016','PRD0000017','PRD0000018','PRD0000019','PRD0000021'], 'panas'),
            ];
        } elseif ($jam >= 11 && $jam <= 14) {
            $segmen = 'siang'; $suhuDefault = 'es'; $rentang = '11.00-14.59';
            $rekomendasi = [
                $slotMenu(1, 'PRD0000030', 'es'), $slotMenu(2, 'PRD0000002', 'es'),
                $slotKelompok(3, 'Minuman Dingin', ['PRD0000037','PRD0000038','PRD0000039','PRD0000040','PRD0000041','PRD0000042','PRD0000016','PRD0000017','PRD0000018','PRD0000019','PRD0000021'], 'es'),
                $slotKelompok(4, 'Nasi Kucing & Sate-satean', ['PRD0000005','PRD0000013','PRD0000014','PRD0000015']),
                $slotKelompok(5, 'Gorengan', ['PRD0000009','PRD0000010','PRD0000011']),
            ];
        } elseif ($jam >= 15 && $jam <= 17) {
            $segmen = 'sore'; $suhuDefault = null; $rentang = '15.00-17.59';
            $rekomendasi = [
                $slotMenu(1, 'PRD0000006'), $slotMenu(2, 'PRD0000007'),
                $slotMenu(3, 'PRD0000008'), $slotMenu(4, 'PRD0000012'),
            ];
        } else {
            $segmen = 'malam'; $suhuDefault = 'es'; $rentang = '18.00-04.59';
            $rekomendasi = [
                $slotMenu(1, 'PRD0000003'), $slotMenu(2, 'PRD0000004'), $slotMenu(3, 'PRD0000001'),
                $slotKelompok(4, 'Minuman Dingin', ['PRD0000037','PRD0000038','PRD0000039','PRD0000040','PRD0000041','PRD0000042','PRD0000016','PRD0000017','PRD0000018','PRD0000019','PRD0000021'], 'es'),
                $slotKelompok(5, 'Gorengan', ['PRD0000009','PRD0000010','PRD0000011']),
            ];
        }

        $emojiSegmen = [
            'pagi'  => '🌅',
            'siang' => '☀️',
            'sore'  => '🌤️',
            'malam' => '🌙',
        ];

        // Enrich gambar & stok dari database
        $rekomendasi = $this->enrichGambar($rekomendasi);
        $rekomendasi = $this->formatKategoriRekomendasi($rekomendasi, $segmen);

        $data = [
            'jam' => $jam,
            'segmen' => $segmen,
            'emoji' => $emojiSegmen[$segmen],
            'hari' => $namaHari,
            'source' => $source,
            'rentang_segmen' => $rentang,
            'suhu_default' => $suhuDefault,
            'total_rekomendasi' => count($rekomendasi),
            'rekomendasi' => $rekomendasi,
        ];
        $data['log_id'] = $this->logRecommendation($data);

        return $this->response
            ->setJSON([
                'status' => 'success',
                'data'   => $data,
            ]);
    }
}
