<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\SettingModel;

class Menu extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/');
        }

        if (session()->get('role') !== 'kasir') {
            return redirect()->to('/');
        }

        $productModel = new ProductModel();
        $settingModel = new SettingModel();

        $settings = [];

        foreach ($settingModel->findAll() as $s) {
            $settings[$s['nama']] = $s['value'];
        }

        return view('kasir/menu/index', [
            'products' => $productModel
                ->orderBy('kategori', 'ASC')
                ->findAll(),

            'nama_warkop' => $settings['nama_warkop'] ?? 'Warkop Bahagia'
        ]);
    }

    public function add()
    {
        $db = \Config\Database::connect();
        $productModel = new ProductModel();

        $file = $this->request->getFile('gambar');
        $gambar = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $gambar = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $gambar);
        }

        // Generate ID Produk
        $lastProduk = $db->table('products')
            ->select('id_produk')
            ->orderBy('id_produk', 'DESC')
            ->get(1)
            ->getRowArray();

        if ($lastProduk) {
            $num = (int) substr($lastProduk['id_produk'], 3) + 1;
        } else {
            $num = 1;
        }

        $id_produk = 'PRD' .
            str_pad($num, 7, '0', STR_PAD_LEFT);

        $productModel->insert([
            'id_produk' => $id_produk,
            'nama'      => $this->request->getPost('nama'),
            'kategori'  => $this->request->getPost('kategori'),
            'harga'     => $this->request->getPost('harga'),
            'stok'      => $this->request->getPost('stok'),
            'varian_suhu' => $this->request->getPost('varian_suhu') ? 1 : 0,
            'tambahan_harga_es' => (float) ($this->request->getPost('tambahan_harga_es') ?? 0),
            'gambar'    => $gambar
        ]);

        // Log aktivitas
        $lastData = $db->table('data_products')
            ->select('id_data')
            ->orderBy('id_data', 'DESC')
            ->get(1)
            ->getRowArray();

        $numData = $lastData
            ? ((int) substr($lastData['id_data'], 3) + 1)
            : 1;

        $id_data = 'DAT' .
            str_pad($numData, 7, '0', STR_PAD_LEFT);

        $db->table('data_products')->insert([
            'id_data'      => $id_data,
            'aktivitas'    => 'Tambah Produk',
            'id_produk'    => $id_produk,
            'nama_produk'  => $this->request->getPost('nama'),
            'nama_kasir'   => session()->get('nama_kasir')
        ]);

        return redirect()->to('/kasir/menu');
    }

    public function edit($id)
    {
        $productModel = new ProductModel();

        return view('kasir/menu/edit', [
            'product' => $productModel->find($id)
        ]);
    }

    public function update($id)
    {
        $db = \Config\Database::connect();
        $productModel = new ProductModel();

        $data = [
            'nama'     => $this->request->getPost('nama'),
            'kategori' => $this->request->getPost('kategori'),
            'harga'    => $this->request->getPost('harga'),
            'stok'     => $this->request->getPost('stok'),
            'varian_suhu' => $this->request->getPost('varian_suhu') ? 1 : 0,
            'tambahan_harga_es' => (float) ($this->request->getPost('tambahan_harga_es') ?? 0),
        ];

        $file = $this->request->getFile('gambar');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $gambar = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $gambar);
            $data['gambar'] = $gambar;
        }

        $productModel->update($id, $data);

        $lastData = $db->table('data_products')
            ->select('id_data')
            ->orderBy('id_data', 'DESC')
            ->get(1)
            ->getRowArray();

        $numData = $lastData
            ? ((int) substr($lastData['id_data'], 3) + 1)
            : 1;

        $id_data = 'DAT' .
            str_pad($numData, 7, '0', STR_PAD_LEFT);

        $db->table('data_products')->insert([
            'id_data'      => $id_data,
            'aktivitas'    => 'Edit Produk',
            'id_produk'    => $id,
            'nama_produk'  => $this->request->getPost('nama'),
            'nama_kasir'   => session()->get('nama_kasir')
        ]);

        return redirect()->to('/kasir/menu');
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $productModel = new ProductModel();

        $produk = $productModel->find($id);

        if ($produk) {

            $lastData = $db->table('data_products')
                ->select('id_data')
                ->orderBy('id_data', 'DESC')
                ->get(1)
                ->getRowArray();

            $numData = $lastData
                ? ((int) substr($lastData['id_data'], 3) + 1)
                : 1;

            $id_data = 'DAT' .
                str_pad($numData, 7, '0', STR_PAD_LEFT);

            $db->table('data_products')->insert([
                'id_data'      => $id_data,
                'aktivitas'    => 'Hapus Produk',
                'id_produk'    => $produk['id_produk'],
                'nama_produk'  => $produk['nama'],
                'nama_kasir'   => session()->get('nama_kasir')
            ]);

            $productModel->delete($id);
        }

        return redirect()->to('/kasir/menu');
    }
}
