<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class Pesanan extends BaseController
{
    public function index()
    {
        if (session()->get('role') !== 'kasir') {
            return redirect()->to('/');
        }

        $db = \Config\Database::connect();

        /* ===============================
           AMBIL PESANAN
        ================================ */

        $orders = $db->table('orders o')

            ->select('
                o.id_order,
                o.id_meja,
                o.nama_pelanggan,
                o.total,
                o.status,
                o.created_at,

                p.id_pay as payment_id,
                p.metode_pembayaran,
                p.total_order,
                p.uang_dibayar,
                p.kembalian,
                p.nama_kasir
            ')

            ->join(
                'payments p',
                'p.id_order = o.id_order',
                'left'
            )

            ->orderBy(
                'o.created_at',
                'DESC'
            )

            ->get()

            ->getResultArray();

        /* ===============================
           SETTINGS
        ================================ */

        $settingModel = new SettingModel();

        $settings = [];

        foreach ($settingModel->findAll() as $s) {

            $settings[$s['nama']]
                = $s['value'];
        }

        return view(
            'kasir/pesanan',
            [

                'orders' => $orders,

                'nama_warkop' =>
                    $settings['nama_warkop']
                    ?? 'Warkop Bahagia'
            ]
        );
    }
}