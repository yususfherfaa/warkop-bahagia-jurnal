<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\SettingModel;

class Order extends BaseController
{
    public function index($id_meja = null)
    {
        if (!$id_meja) {
            die('Meja tidak valid');
        }

        $db = \Config\Database::connect();

        // VALIDASI MEJA
        $meja = $db->table('tables_meja')
            ->where('id_meja', $id_meja)
            ->get()
            ->getRowArray();

        if (!$meja) {
            die('Meja tidak ditemukan');
        }

        // PRODUK
        $productModel = new ProductModel();

        $prodBuilder = $productModel->orderBy('nama', 'ASC');
        if ($db->fieldExists('aktif', 'products')) {
            $prodBuilder->where('aktif', 1);
        }
        $products = $prodBuilder->findAll();
        $categoryOrder = [
            'Kopi Panas',
            'Es Kopi',
            'Es Nutrisari',
            'Minuman Non Kopi',
            'Makanan Berat',
            'Cemilan',
            'Minuman Kopi',
        ];
        usort($products, static function (array $left, array $right) use ($categoryOrder): int {
            $leftRank = array_search($left['kategori'], $categoryOrder, true);
            $rightRank = array_search($right['kategori'], $categoryOrder, true);
            $leftRank = $leftRank === false ? count($categoryOrder) : $leftRank;
            $rightRank = $rightRank === false ? count($categoryOrder) : $rightRank;
            return $leftRank <=> $rightRank ?: strcasecmp($left['nama'], $right['nama']);
        });
        $optionsByProduct = [];
        foreach ($db->table('product_options')
            ->where('aktif', 1)
            ->orderBy('urutan', 'ASC')
            ->get()
            ->getResultArray() as $option) {
            $optionsByProduct[$option['id_produk']][] = $option;
        }
        foreach ($products as &$product) {
            $product['options'] = $optionsByProduct[$product['id_produk']] ?? [];
            if (in_array($product['kategori'], ['Makanan Berat', 'Cemilan'], true)) {
                $product['label_opsi'] = 'Pilih varian';
            }
        }
        unset($product);

        // SETTINGS
        $settingModel = new SettingModel();

        $settings = [];

        foreach ($settingModel->findAll() as $s) {
            $settings[$s['nama']] = $s['value'];
        }

        $data = [

            'id_meja' => $id_meja,

            'meja' => $meja,

            'products' => $products,

            'nama_warkop' =>
                $settings['nama_warkop']
                ?? 'Warkop Bahagia',

            'alamat' =>
                $settings['alamat']
                ?? 'Alamat belum diatur',

            'kontak' =>
                $settings['kontak']
                ?? '-',

            'logo' =>
                $settings['logo']
                ?? 'default-logo.png'
        ];

        return view('customer/order', $data);
    }
}