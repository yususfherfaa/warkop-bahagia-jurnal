<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MenuMinumanSeeder extends Seeder
{
    private const DESCRIPTIONS = [
        'PRD0000001' => 'Nasi goreng berbumbu gurih yang nikmat disantap hangat.',
        'PRD0000002' => 'Mi goreng berbumbu dengan tambahan telur.',
        'PRD0000003' => 'Mi kuah hangat dengan bumbu gurih dan tambahan telur.',
        'PRD0000004' => 'Bubur kacang hijau manis dan lembut untuk teman santai.',
        'PRD0000005' => 'Porsi nasi sederhana yang pas untuk camilan atau teman ngopi.',
        'PRD0000006' => 'Kue pancong hangat dengan taburan keju gurih.',
        'PRD0000007' => 'Roti bakar hangat dengan isian cokelat manis.',
        'PRD0000008' => 'Kentang goreng renyah yang cocok untuk camilan.',
        'PRD0000009' => 'Bakwan goreng gurih dan renyah, disajikan per buah.',
        'PRD0000010' => 'Tempe goreng gurih sebagai camilan atau lauk, disajikan per buah.',
        'PRD0000011' => 'Tahu goreng gurih sebagai camilan atau lauk, disajikan per buah.',
        'PRD0000012' => 'Dimsum lembut dengan saus mentai yang gurih dan creamy.',
        'PRD0000013' => 'Sate telur gurih yang praktis dinikmati sebagai camilan.',
        'PRD0000014' => 'Sate usus berbumbu gurih, disajikan per tusuk.',
        'PRD0000015' => 'Sate ati ampela berbumbu gurih, disajikan per tusuk.',
        'PRD0000016' => 'Minuman cokelat malt yang nikmat disajikan panas atau es.',
        'PRD0000017' => 'Minuman rasa jeruk yang menyegarkan, tersedia panas atau es.',
        'PRD0000018' => 'Teh dengan rasa manis yang pas, dapat dinikmati panas atau es.',
        'PRD0000019' => 'Perpaduan teh dan lemon dengan rasa segar, tersedia panas atau es.',
        'PRD0000021' => 'Susu putih dengan rasa lembut, dapat dinikmati panas atau es.',
        'PRD0000022' => 'Air mineral untuk menemani makan atau melepas dahaga.',
        'PRD0000023' => 'Kopi cappuccino dengan perpaduan rasa kopi dan susu yang creamy.',
        'PRD0000024' => 'Kopi dengan campuran susu yang lembut dan seimbang.',
        'PRD0000025' => 'Kopi hitam dengan cita rasa kopi yang kuat dan sederhana.',
        'PRD0000026' => 'Nasi kuning berbumbu gurih, cocok untuk menu makan yang mengenyangkan.',
        'PRD0000027' => 'Nasi uduk gurih yang cocok dinikmati sebagai menu makan.',
        'PRD0000028' => 'Lontong sayur dengan kuah berbumbu gurih untuk santapan mengenyangkan.',
        'PRD0000029' => 'Bubur ayam hangat dengan rasa gurih, pas untuk santapan ringan.',
        'PRD0000030' => 'Ayam geprek dengan nasi, pilihan makan gurih dan mengenyangkan.',
        'PRD0000031' => 'Kopi instan bercita rasa kopi dan susu yang nikmat disajikan panas.',
        'PRD0000032' => 'Kopi instan dengan rasa lembut untuk menemani waktu santai.',
        'PRD0000033' => 'Kopi instan dengan perpaduan kopi dan gula yang praktis disajikan panas.',
        'PRD0000034' => 'Kopi Good Day panas dengan pilihan rasa yang bisa dipilih.',
        'PRD0000035' => 'Kopi putih bercita rasa lembut dan creamy, disajikan panas.',
        'PRD0000036' => 'Kopi latte dengan perpaduan kopi dan krimer yang creamy.',
        'PRD0000037' => 'Kopi Good Day Freeze dingin dengan pilihan rasa yang bisa dipilih.',
        'PRD0000038' => 'Kopi dingin dengan rasa kopi yang kuat dan menyegarkan.',
        'PRD0000039' => 'Kopi dingin dengan sentuhan rasa klepon yang manis dan creamy.',
        'PRD0000040' => 'Good Day Biasa disajikan dingin dengan pilihan rasa yang bisa dipilih.',
        'PRD0000041' => 'Kopi instan dingin dengan rasa kopi dan susu yang lembut.',
        'PRD0000042' => 'Minuman Nutrisari dingin dengan pilihan rasa buah yang menyegarkan.',
    ];

    private const PRODUCTS = [
        ['PRD0000031', 'ABC Susu', 'Kopi Panas', 5000, 'abc-susu.svg', 'panas', []],
        ['PRD0000032', 'Indocafe', 'Kopi Panas', 5000, 'indocafe.svg', 'panas', []],
        ['PRD0000033', 'Kapal Api Special Mix', 'Kopi Panas', 5000, 'kapal-api-special-mix.svg', 'panas', []],
        ['PRD0000034', 'Good Day Biasa', 'Kopi Panas', 6000, 'good-day-hot.svg', 'panas', [
            'Cappuccino', 'Moccacino', 'Vanilla Latte', 'Carribean Nut', "Coolin' Caffe",
        ]],
        ['PRD0000035', 'Luwak White Coffee', 'Kopi Panas', 5000, 'luwak-white-coffee.svg', 'panas', []],
        ['PRD0000036', 'Torabika Creamy Latte', 'Kopi Panas', 6000, 'torabika-creamy-latte.svg', 'panas', []],
        ['PRD0000037', 'Good Day Freeze', 'Es Kopi', 8000, 'good-day-freeze.svg', 'dingin', [
            'Mocafrio', 'Hazelnut Macchiato', "Cookies 'N Cream", 'Choc Orange',
        ]],
        ['PRD0000038', 'Nescafe Ice Roast', 'Es Kopi', 7000, 'nescafe-ice-roast.svg', 'dingin', []],
        ['PRD0000039', 'ABC Klepon', 'Es Kopi', 8000, 'abc-klepon.svg', 'dingin', []],
        ['PRD0000040', 'Good Day Biasa', 'Es Kopi', 7000, 'good-day-iced.svg', 'dingin', [
            'Cappuccino', 'Moccacino', 'Vanilla Latte', 'Carribean Nut', "Coolin' Caffe",
        ]],
        ['PRD0000041', 'Tora Cafe', 'Es Kopi', 7000, 'tora-cafe.svg', 'dingin', []],
        ['PRD0000042', 'Es Nutrisari', 'Es Nutrisari', 5000, 'fruit-drink.svg', 'dingin', [
            'Jeruk Nipis', 'Anggur', 'Lemon', 'Jeruk Peras',
        ]],
    ];

    public function run()
    {
        $nextActivityNumber = $this->nextActivityNumber();
        $this->db->transBegin();

        try {
            foreach (self::PRODUCTS as $product) {
                [$id, $name, $category, $price, $image, $temperature, $options] = $product;
                $imagePath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . $image;
                if (!is_file($imagePath)) {
                    throw new \RuntimeException('Gambar menu tidak ditemukan: ' . $imagePath);
                }

                $productData = [
                    'nama' => $name,
                    'kategori' => $category,
                    'harga' => $price,
                    'varian_suhu' => 0,
                    'tambahan_harga_es' => 0,
                    'gambar' => $image,
                    'suhu_tetap' => $temperature,
                    'punya_opsi' => $options === [] ? 0 : 1,
                    'label_opsi' => $options === [] ? null : 'Pilih rasa',
                ];
                $exists = $this->db->table('products')->where('id_produk', $id)->countAllResults() > 0;
                if ($exists) {
                    $productData['stok'] = 50;
                    if ($this->db->table('order_items')->where('id_produk', $id)->countAllResults() > 0) {
                        unset($productData['stok']);
                    }
                    $this->db->table('products')->where('id_produk', $id)->update($productData);
                } else {
                    $this->db->table('products')->insert([
                        'id_produk' => $id,
                        'stok' => 50,
                        ...$productData,
                    ]);
                    $this->insertActivity($nextActivityNumber++, $id, $name);
                }

                $this->db->table('data_products')
                    ->where('id_produk', $id)
                    ->update(['nama_produk' => $name]);

                $this->fillMissingDescription($id);
                $this->syncOptions($id, $options);
            }

            foreach (self::DESCRIPTIONS as $id => $description) {
                $this->db->table('products')
                    ->where('id_produk', $id)
                    ->groupStart()
                    ->where('deskripsi', null)
                    ->orWhere('deskripsi', '')
                    ->groupEnd()
                    ->update(['deskripsi' => $description]);
            }

            $this->db->transCommit();
        } catch (\Throwable $exception) {
            $this->db->transRollback();
            throw $exception;
        }

        echo "Katalog 12 produk dan pilihan rasa berhasil disinkronkan.\n";
    }

    private function fillMissingDescription(string $productId): void
    {
        $this->db->table('products')
            ->where('id_produk', $productId)
            ->groupStart()
            ->where('deskripsi', null)
            ->orWhere('deskripsi', '')
            ->groupEnd()
            ->update(['deskripsi' => self::DESCRIPTIONS[$productId] ?? null]);
    }

    private function syncOptions(string $productId, array $names): void
    {
        $existingOptions = $this->db->table('product_options')
            ->where('id_produk', $productId)
            ->get()
            ->getResultArray();
        $existingByName = [];
        foreach ($existingOptions as $option) {
            $existingByName[$option['nama_opsi']] = $option;
        }

        foreach ($names as $index => $name) {
            $id = 'OPT' . str_pad((string) ($this->optionOffset($productId) + $index + 1), 7, '0', STR_PAD_LEFT);
            $data = [
                'id_opsi' => $id,
                'id_produk' => $productId,
                'nama_opsi' => $name,
                'tambahan_harga' => 0,
                'urutan' => $index + 1,
                'aktif' => 1,
            ];

            if (isset($existingByName[$name])) {
                $this->db->table('product_options')
                    ->where('id_opsi', $existingByName[$name]['id_opsi'])
                    ->update(array_diff_key($data, ['id_produk' => true]));
                continue;
            }

            $this->db->table('product_options')->replace($data);
        }

        $activeNames = $names;
        foreach ($existingOptions as $option) {
            if (!in_array($option['nama_opsi'], $activeNames, true)) {
                $this->db->table('product_options')
                    ->where('id_opsi', $option['id_opsi'])
                    ->update(['aktif' => 0]);
            }
        }
    }

    private function optionOffset(string $productId): int
    {
        return match ($productId) {
            'PRD0000034' => 0,
            'PRD0000037' => 5,
            'PRD0000040' => 9,
            'PRD0000042' => 14,
            default => 0,
        };
    }

    private function insertActivity(int $number, string $productId, string $name): void
    {
        $this->db->table('data_products')->insert([
            'id_data' => 'DAT' . str_pad((string) $number, 7, '0', STR_PAD_LEFT),
            'aktivitas' => 'Tambah Produk',
            'id_produk' => $productId,
            'nama_produk' => $name,
            'nama_kasir' => 'Admin',
        ]);
    }

    private function nextActivityNumber(): int
    {
        $last = $this->db->table('data_products')
            ->select('id_data')
            ->like('id_data', 'DAT', 'after')
            ->orderBy('id_data', 'DESC')
            ->get(1)
            ->getRowArray();

        return $last ? (int) substr($last['id_data'], 3) + 1 : 1;
    }
}
