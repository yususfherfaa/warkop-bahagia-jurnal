<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class OrderSuccess extends BaseController
{
    public function index($id_order = null, $id_meja = null)
    {
        if (!$id_order) {
            die('Order tidak valid');
        }

        $db = \Config\Database::connect();

        // ambil order
        $order = $db->table('orders')
            ->where('id_order', $id_order)
            ->get()
            ->getRowArray();

        if (!$order) {
            die('Pesanan tidak ditemukan');
        }

        // ambil item
        $items = $db->table('order_items')
            ->where('id_order', $id_order)
            ->get()
            ->getResultArray();

        return view('customer/order_success', [

            'order'     => $order,

            'items'     => $items,

            'id_meja'   => $id_meja
        ]);
    }
}