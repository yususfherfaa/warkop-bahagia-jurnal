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

        if (!$order) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'status' => 'not_found',
                    'message' => 'Pesanan tidak ditemukan.',
                ]);
        }

        return $this->response->setJSON([
            'status' => $order['status']
        ]);
    }
}