<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Checkout extends BaseController
{
    public function index($id_meja)
    {
        $db = \Config\Database::connect();

        // ambil cart
        $items = session()->get('cart_'.$id_meja) ?? [];

        // kalau cart kosong
        if (empty($items)) {
            return redirect()->to('/cart/'.$id_meja);
        }

        // hitung total
        $total = 0;

        foreach ($items as $item) {
            $total += $item['harga'] * $item['qty'];
        }

        $metode_pembayaran =
        $this->request->getPost('metode_pembayaran')
        ?? 'cash';

        // =========================
        // GENERATE ID ORDER
        // =========================

        $lastOrder = $db->table('orders')
            ->select('id_order')
            ->orderBy('id_order', 'DESC')
            ->get(1)
            ->getRowArray();

        if ($lastOrder) {

            $num = (int) substr($lastOrder['id_order'], 3) + 1;

        } else {

            $num = 1;
        }

        $id_order = 'ORD' .
            str_pad($num, 7, '0', STR_PAD_LEFT);

        // =========================
        // SIMPAN ORDER
        // =========================

        $db->table('orders')->insert([

            'id_order'        => $id_order,

            'id_meja'         => $id_meja,

            'nama_pelanggan'  =>
                $this->request->getPost('nama_pelanggan'),

            'metode_pembayaran' =>
            $this->request->getPost('metode_pembayaran'),

            'total'           => $total,

            'status'          => 'pending',

            'created_at'      => date('Y-m-d H:i:s')
        ]);

        // =========================
        // SIMPAN ORDER ITEMS
        // =========================

        foreach ($items as $item) {

            $lastItem = $db->table('order_items')
                ->select('id_items')
                ->orderBy('id_items', 'DESC')
                ->get(1)
                ->getRowArray();

            if ($lastItem) {

                $numItem =
                    (int) substr($lastItem['id_items'], 3) + 1;

            } else {

                $numItem = 1;
            }

            $id_items = 'ITM' .
                str_pad($numItem, 7, '0', STR_PAD_LEFT);

            $suhu = $item['suhu'] ?? null;
            $namaItem = $item['nama'];
            if ($suhu === 'panas') {
                $namaItem .= ' (Panas)';
            } elseif ($suhu === 'es') {
                $namaItem .= ' (Es)';
            }

            $db->table('order_items')->insert([

                'id_items'   => $id_items,

                'id_order'   => $id_order,

                'id_produk'  => $item['id_produk'],

                'nama'       => $namaItem,

                'kategori'   => $item['kategori'] ?? '',

                'suhu'       => $suhu,

                'harga'      => $item['harga'],

                'qty'        => $item['qty'],

                'subtotal'   =>
                    $item['harga'] *
                    $item['qty']
            ]);

            // Kurangi stok produk
            $db->table('products')
                ->set('stok', 'CASE WHEN stok - ' . $item['qty'] . ' < 0 THEN 0 ELSE stok - ' . $item['qty'] . ' END', false)
                ->where('id_produk', $item['id_produk'])
                ->update();
        }

        // =========================
        // INSERT NOTIFIKASI
        // =========================
        $db->table('notifications')->insert([
            'id_order'        => $id_order,
            'id_meja'         => $id_meja,
            'nama_pelanggan'  => $this->request->getPost('nama_pelanggan'),
            'total'           => $total,
            'status'          => 'unread',
            'created_at'      => date('Y-m-d H:i:s')
        ]);

        // hapus cart
        session()->remove('cart_'.$id_meja);

        // jika QRIS tampilkan halaman QRIS
        if ($metode_pembayaran == 'qris') {

        return redirect()->to(
        '/payment-qris/'.$id_order.'/'.$id_meja
        );
        }

        // jika tunai langsung sukses
        return redirect()->to(
        '/order-success/'.$id_order.'/'.$id_meja
        );
    }
}
