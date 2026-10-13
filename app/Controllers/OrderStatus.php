<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class OrderStatus extends BaseController
{
    public function cek($id_order)
    {
        $db = \Config\Database::connect();

        $order = $db->table('orders')
            ->where('id_order', $id_order)
            ->get()
            ->getRowArray();

        return $this->response->setJSON([
            'status' => $order['status']
        ]);
    }
}