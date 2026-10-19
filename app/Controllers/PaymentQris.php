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

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pesanan tidak ditemukan.');
        }

        $merchantName = trim((string) (setting('nama_warkop') ?? 'Warkop Bahagia'));
        $merchantAddress = trim((string) (setting('alamat') ?? 'Bekasi Utara'));
        $qris = trim((string) (setting('qris') ?? 'uploads/qris.png'));

        return view('customer/payment_qris', [
            'order' => $order,
            'id_meja' => $id_meja,
            'merchant_name' => $merchantName ?: 'Warkop Bahagia',
            'merchant_address' => $merchantAddress ?: 'Bekasi Utara',
            'qris' => $qris ?: 'uploads/qris.png',
        ]);
    }
}