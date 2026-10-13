<?php

namespace App\Controllers;

use App\Controllers\BaseController;

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
    /**
     * Ambil rekomendasi menu berdasarkan jam real-time.
     */
    public function index()
    {
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
                foreach (['id_produk','nama','kategori','harga','gambar','stok','varian_suhu','tambahan_harga_es'] as $key) {
                    $it[$key] = $first[$key] ?? ($it[$key] ?? null);
                }
                continue;
            }

            $row = $db->table('products')
                ->select('nama, kategori, harga, gambar, stok, varian_suhu, tambahan_harga_es')
                ->where('id_produk', $it['id_produk'] ?? '')
                ->get()->getRowArray();

            if ($row) {
                $it['nama'] = $row['nama'];
                $it['kategori'] = $row['kategori'];
                $it['harga'] = (float) $row['harga'];
                $it['varian_suhu'] = (int) $row['varian_suhu'];
                $it['tambahan_harga_es'] = (float) $row['tambahan_harga_es'];
            }
            $it['gambar'] = !empty($row['gambar'])
                ? base_url('uploads/' . $row['gambar'])
                : base_url('assets/noimage.png');
            $it['stok'] = isset($row['stok']) ? (int) $row['stok'] : null;
        }
        unset($it);
        return $items;
    }

    /**
     * Core: request ke Flask API server (localhost:5001) dan return JSON.
     */
    private function getRekomendasiByJam($jam)
    {
        $url = 'http://127.0.0.1:5001/api/rekomendasi';
        if ($jam !== null) {
            $url .= '?jam=' . $jam;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($output === false || $httpcode !== 200) {
            // Fallback: gunakan rule-based jika Flask tidak tersedia
            return $this->fallbackRuleBased($jam);
        }

        $hasil = json_decode($output, true);

        if (!$hasil || !isset($hasil['data'])) {
            return $this->fallbackRuleBased($jam);
        }

        if (isset($hasil['data']['rekomendasi']) && is_array($hasil['data']['rekomendasi'])) {
            $hasil['data']['rekomendasi'] = $this->enrichGambar($hasil['data']['rekomendasi']);
        }

        return $this->response
            ->setJSON($hasil)
            ->setHeader('Access-Control-Allow-Origin', '*');
    }

    /**
     * Fallback rule-based jika Python/model tidak tersedia.
     * Tetap memberikan rekomendasi tanpa ML.
     */
    private function fallbackRuleBased($jam = null)
    {
        $now    = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));
        $jam    = $jam ?? (int) $now->format('H');
        $hari   = (int) $now->format('N') - 1; // 0=Senin
        $namaHari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'][$hari];

        $slotMenu = fn($rank, $id, $suhu = null) => ['peringkat' => $rank, 'tipe' => 'menu', 'id_produk' => $id, 'suhu_default' => $suhu];
        $slotKelompok = fn($rank, $nama, $ids, $suhu = null) => [
            'peringkat' => $rank, 'tipe' => 'kelompok', 'nama_kelompok' => $nama, 'nama' => $nama,
            'anggota' => array_map(fn($id) => ['id_produk' => $id], $ids), 'suhu_default' => $suhu
        ];

        if ($jam >= 5 && $jam <= 10) {
            $segmen = 'pagi'; $suhuDefault = 'panas'; $rentang = '05.00-10.59';
            $rekomendasi = [
                $slotMenu(1, 'PRD0000026', 'panas'), $slotMenu(2, 'PRD0000027', 'panas'),
                $slotMenu(3, 'PRD0000028', 'panas'), $slotMenu(4, 'PRD0000029', 'panas'),
                $slotKelompok(5, 'Kopi & Teh Panas', ['PRD0000024','PRD0000025','PRD0000018'], 'panas'),
            ];
        } elseif ($jam >= 11 && $jam <= 14) {
            $segmen = 'siang'; $suhuDefault = 'es'; $rentang = '11.00-14.59';
            $rekomendasi = [
                $slotMenu(1, 'PRD0000030', 'es'), $slotMenu(2, 'PRD0000002', 'es'),
                $slotKelompok(3, 'Es Segar', ['PRD0000019','PRD0000018','PRD0000017'], 'es'),
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
                $slotKelompok(4, 'Es Kopi & Minuman Manis', ['PRD0000024','PRD0000025','PRD0000023','PRD0000016','PRD0000021'], 'es'),
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

        return $this->response
            ->setJSON([
                'status' => 'success',
                'data'   => [
                    'jam'                => $jam,
                    'segmen'             => $segmen,
                    'emoji'              => $emojiSegmen[$segmen],
                    'hari'               => $namaHari,
                    'source'             => 'rule-based',
                    'rentang_segmen'     => $rentang,
                    'suhu_default'       => $suhuDefault,
                    'total_rekomendasi'  => count($rekomendasi),
                    'rekomendasi'        => $rekomendasi,
                ],
            ])
            ->setHeader('Access-Control-Allow-Origin', '*');
    }
}
