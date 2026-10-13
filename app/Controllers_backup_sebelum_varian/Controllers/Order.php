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

        $products = $productModel
            ->orderBy('kategori', 'ASC')
            ->findAll();

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