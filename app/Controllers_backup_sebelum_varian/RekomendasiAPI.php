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
            $row = $db->table('products')
                ->select('gambar, stok')
                ->where('id_produk', $it['id_produk'] ?? '')
                ->get()->getRowArray();

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

        if ($jam >= 5 && $jam <= 10) {
            $segmen       = 'pagi';
            $rekomendasi  = [
                ['id_produk' => 'PRD0000001', 'nama' => 'Nasi Goreng',         'kategori' => 'Makanan Berat',    'harga' => 16000],
                ['id_produk' => 'PRD0000004', 'nama' => 'Bubur Kacang Ijo',    'kategori' => 'Makanan Berat',    'harga' => 12000],
                ['id_produk' => 'PRD0000003', 'nama' => 'Indomie Rebus Telor', 'kategori' => 'Makanan Berat',    'harga' => 14000],
                ['id_produk' => 'PRD0000024', 'nama' => 'Kopi Susu',           'kategori' => 'Minuman Kopi',     'harga' =>  5000],
                ['id_produk' => 'PRD0000025', 'nama' => 'Kopi Item',           'kategori' => 'Minuman Kopi',     'harga' =>  3000],
                ['id_produk' => 'PRD0000020', 'nama' => 'Teh Anget Manis',     'kategori' => 'Minuman Non Kopi', 'harga' =>  4000],
                ['id_produk' => 'PRD0000007', 'nama' => 'Roti Bakar Coklat',   'kategori' => 'Cemilan',          'harga' =>  8000],
            ];
        } elseif ($jam >= 11 && $jam <= 14) {
            $segmen       = 'siang';
            $rekomendasi  = [
                ['id_produk' => 'PRD0000001', 'nama' => 'Nasi Goreng',          'kategori' => 'Makanan Berat',    'harga' => 16000],
                ['id_produk' => 'PRD0000002', 'nama' => 'Indomie Goreng Telor', 'kategori' => 'Makanan Berat',    'harga' => 14000],
                ['id_produk' => 'PRD0000005', 'nama' => 'Nasi Kucing',          'kategori' => 'Makanan Berat',    'harga' =>  8000],
                ['id_produk' => 'PRD0000017', 'nama' => 'Es Jeruk',             'kategori' => 'Minuman Non Kopi', 'harga' =>  6000],
                ['id_produk' => 'PRD0000016', 'nama' => 'Es Milo',              'kategori' => 'Minuman Non Kopi', 'harga' =>  7000],
                ['id_produk' => 'PRD0000018', 'nama' => 'Es Teh Manis',         'kategori' => 'Minuman Non Kopi', 'harga' =>  5000],
                ['id_produk' => 'PRD0000019', 'nama' => 'Es Lemon Tea',         'kategori' => 'Minuman Non Kopi', 'harga' =>  7000],
            ];
        } elseif ($jam >= 15 && $jam <= 17) {
            $segmen       = 'sore';
            $rekomendasi  = [
                ['id_produk' => 'PRD0000006', 'nama' => 'Pancong Keju',          'kategori' => 'Cemilan', 'harga' => 10000],
                ['id_produk' => 'PRD0000008', 'nama' => 'Kentang Goreng',        'kategori' => 'Cemilan', 'harga' => 10000],
                ['id_produk' => 'PRD0000012', 'nama' => 'Dimsum Mentai',         'kategori' => 'Cemilan', 'harga' => 15000],
                ['id_produk' => 'PRD0000007', 'nama' => 'Roti Bakar Coklat',     'kategori' => 'Cemilan', 'harga' =>  8000],
                ['id_produk' => 'PRD0000013', 'nama' => 'Sate Telor 1 Pcs',      'kategori' => 'Cemilan', 'harga' =>  3000],
                ['id_produk' => 'PRD0000009', 'nama' => 'Bakwan 1 Pcs',          'kategori' => 'Cemilan', 'harga' =>  2000],
                ['id_produk' => 'PRD0000016', 'nama' => 'Es Milo',               'kategori' => 'Minuman Non Kopi', 'harga' => 7000],
            ];
        } else {
            $segmen       = 'malam';
            $rekomendasi  = [
                ['id_produk' => 'PRD0000003', 'nama' => 'Indomie Rebus Telor',  'kategori' => 'Makanan Berat',    'harga' => 14000],
                ['id_produk' => 'PRD0000001', 'nama' => 'Nasi Goreng',          'kategori' => 'Makanan Berat',    'harga' => 16000],
                ['id_produk' => 'PRD0000023', 'nama' => 'Capucinno',            'kategori' => 'Minuman Kopi',     'harga' =>  8000],
                ['id_produk' => 'PRD0000024', 'nama' => 'Kopi Susu',            'kategori' => 'Minuman Kopi',     'harga' =>  5000],
                ['id_produk' => 'PRD0000025', 'nama' => 'Kopi Item',            'kategori' => 'Minuman Kopi',     'harga' =>  3000],
                ['id_produk' => 'PRD0000020', 'nama' => 'Teh Anget Manis',      'kategori' => 'Minuman Non Kopi', 'harga' =>  4000],
                ['id_produk' => 'PRD0000012', 'nama' => 'Dimsum Mentai',        'kategori' => 'Cemilan',          'harga' => 15000],
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
                    'total_rekomendasi'  => count($rekomendasi),
                    'rekomendasi'        => $rekomendasi,
                    'source'             => 'rule-based',
                ],
            ])
            ->setHeader('Access-Control-Allow-Origin', '*');
    }
}
