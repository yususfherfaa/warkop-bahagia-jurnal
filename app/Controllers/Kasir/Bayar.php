<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\PaymentModel;
use App\Models\SettingModel;

class Bayar extends BaseController
{
    public function index($id_order)
    {
        if (session()->get('role') !== 'kasir') {
            return redirect()->to('/');
        }

        $orderModel = new OrderModel();
        $itemModel = new OrderItemModel();
        $settingModel = new SettingModel();

        $order = $orderModel->find($id_order);

        if (!$order) {
            return 'Pesanan tidak ditemukan';
        }

        $items = $itemModel
            ->where('id_order', $id_order)
            ->findAll();

        $settings = [];

        foreach ($settingModel->findAll() as $s) {
            $settings[$s['nama']] = $s['value'];
        }

        $data = [
            'order' => $order,
            'items' => $items,
            'nama_warkop' => $settings['nama_warkop'] ?? 'Warkop Bahagia'
        ];

        return view('kasir/bayar', $data);
    }

    public function process($id_order)
    {
        if (session()->get('role') !== 'kasir') {
            return redirect()->to('/');
        }

        $orderModel = new OrderModel();
        $paymentModel = new PaymentModel();

        $order = $orderModel->find($id_order);

        if (!$order) {
            return 'Pesanan tidak ditemukan';
        }

        $uang_dibayar = (int)$this->request->getPost('uang_dibayar');
        $total_order  = (int)$order['total'];

        if ($uang_dibayar < $total_order) {
            return redirect()->back()->with('error', 'Uang dibayar kurang');
        }

        $kembalian = $uang_dibayar - $total_order;

        $paymentId = $this->generateIdPay();

        $paymentModel->insert([
            'id_pay' => $paymentId,
            'id_order' => $id_order,
            'id_user' => session()->get('id_user'),
            'metode_pembayaran' => $order['metode_pembayaran'],
            'total_order' => $total_order,
            'uang_dibayar' => $uang_dibayar,
            'kembalian' => $kembalian,
            'nama_kasir' => session()->get('nama_kasir')
        ]);

       $orderModel->update($id_order, [
    'status' => 'lunas',
    'id_pay' => $paymentId
]);

        return redirect()->to('/kasir/struk/' . $id_order);
    }

    private function generateIdPay()
{
    $db = \Config\Database::connect();
    $builder = $db->table('payments');

    $last = $builder
        ->select('id_pay')
        ->orderBy('id_pay', 'DESC')
        ->limit(1)
        ->get()
        ->getRowArray();

    if (!$last) {
        return 'PAY000001';
    }

    $lastNumber = (int) substr($last['id_pay'], 3);
    $nextNumber = $lastNumber + 1;

    return 'PAY' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
}
}