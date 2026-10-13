<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PaymentQris extends BaseController
{
    public function index($id_order, $id_meja)
    {
        $db = \Config\Database::connect();

        $order = $db->table('orders')
            ->where('id_order', $id_order)
            ->get()
            ->getRowArray();

        return view('customer/payment_qris', [
            'order' => $order,
            'id_meja' => $id_meja
        ]);
    }
}