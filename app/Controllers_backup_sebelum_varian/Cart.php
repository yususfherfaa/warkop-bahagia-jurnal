<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Cart extends BaseController
{
    public function add($id_produk, $id_meja)
    {
        $db = \Config\Database::connect();

        $produk = $db->table('products')
            ->where('id_produk', $id_produk)
            ->get()
            ->getRowArray();

        if (!$produk || $produk['stok'] <= 0) {
            return redirect()->back();
        }

        // ambil cart
        $cart = session()->get('cart_'.$id_meja) ?? [];

        // tambah qty
        if (isset($cart[$id_produk])) {

            if ($cart[$id_produk]['qty'] < $produk['stok']) {
                $cart[$id_produk]['qty']++;
            }

        } else {

            $cart[$id_produk] = [

                'id_produk' => $produk['id_produk'],
                'nama'      => $produk['nama'],
                'harga'     => $produk['harga'],
                'qty'       => 1
            ];
        }

        // simpan
        session()->set('cart_'.$id_meja, $cart);

        return redirect()->to('/cart/'.$id_meja);
    }

    public function index($id_meja)
{
    $sessionKey = 'cart_' . $id_meja;

    $cart = session()->get($sessionKey) ?? [];

    // reset index array
    $items = array_values($cart);

    $total = 0;

    foreach ($items as $item) {

        $total += $item['harga'] * $item['qty'];
    }

    return view('customer/cart', [

        'items' => $items,

        'total' => $total,

        'id_meja' => $id_meja
    ]);
}
public function qty($id_meja, $id_produk, $type)
{
    $sessionKey = 'cart_' . $id_meja;

    $cart = session()->get($sessionKey) ?? [];

    if (isset($cart[$id_produk])) {

        if ($type == 'plus') {

            $produk = \Config\Database::connect()->table('products')->where('id_produk', $id_produk)->get()->getRowArray();
            if ($produk && $cart[$id_produk]['qty'] < $produk['stok']) {
                $cart[$id_produk]['qty']++;
            }

        } elseif ($type == 'minus') {

            $cart[$id_produk]['qty']--;

            if ($cart[$id_produk]['qty'] <= 0) {

                unset($cart[$id_produk]);
            }
        }
    }

    session()->set($sessionKey, $cart);

    return redirect()->to('/cart/'.$id_meja);
}

    public function remove($id_meja, $id_produk)
{
    $sessionKey = 'cart_' . $id_meja;

    $cart = session()->get($sessionKey) ?? [];

    // debug isi cart
    // dd($cart);

    if (isset($cart[$id_produk])) {

        unset($cart[$id_produk]);
    }

    // simpan ulang session
    session()->set($sessionKey, $cart);

    return redirect()->to('/cart/' . $id_meja);
}
}