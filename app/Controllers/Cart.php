<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Cart extends BaseController
{
    private function suhuValid(?string $suhu): ?string
    {
        $suhu = strtolower((string) $suhu);
        return in_array($suhu, ['panas', 'es'], true) ? $suhu : null;
    }

    private function totalQtyProduk(array $cart, string $id_produk): int
    {
        $total = 0;
        foreach ($cart as $item) {
            if (($item['id_produk'] ?? null) === $id_produk) {
                $total += (int) ($item['qty'] ?? 0);
            }
        }
        return $total;
    }

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

        $cart = session()->get('cart_'.$id_meja) ?? [];
        $suhu = !empty($produk['varian_suhu']) ? $this->suhuValid($this->request->getGet('suhu')) : null;
        if (!empty($produk['varian_suhu']) && $suhu === null) {
            $suhu = 'panas';
        }

        $key = $suhu ? $id_produk . '_' . $suhu : $id_produk;
        $harga = (float) $produk['harga'] + ($suhu === 'es' ? (float) ($produk['tambahan_harga_es'] ?? 0) : 0);
        $totalProdukDiCart = $this->totalQtyProduk($cart, $id_produk);

        if (isset($cart[$key])) {
            if ($totalProdukDiCart < (int) $produk['stok']) {
                $cart[$key]['qty']++;
            }
        } else {
            if ($totalProdukDiCart >= (int) $produk['stok']) {
                return redirect()->to('/cart/'.$id_meja);
            }
            $cart[$key] = [
                'id_produk' => $produk['id_produk'],
                'nama'      => $produk['nama'],
                'kategori'  => $produk['kategori'],
                'suhu'      => $suhu,
                'harga'     => $harga,
                'qty'       => 1,
                'key'       => $key,
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
public function qty($id_meja, $key, $type)
{
    $sessionKey = 'cart_' . $id_meja;

    $cart = session()->get($sessionKey) ?? [];

    if (isset($cart[$key])) {
        $id_produk = $cart[$key]['id_produk'];

        if ($type == 'plus') {

            $produk = \Config\Database::connect()->table('products')->where('id_produk', $id_produk)->get()->getRowArray();
            if ($produk && $this->totalQtyProduk($cart, $id_produk) < (int) $produk['stok']) {
                $cart[$key]['qty']++;
            }

        } elseif ($type == 'minus') {

            $cart[$key]['qty']--;

            if ($cart[$key]['qty'] <= 0) {

                unset($cart[$key]);
            }
        }
    }

    session()->set($sessionKey, $cart);

    return redirect()->to('/cart/'.$id_meja);
}

    public function remove($id_meja, $key)
{
    $sessionKey = 'cart_' . $id_meja;

    $cart = session()->get($sessionKey) ?? [];

    // debug isi cart
    // dd($cart);

    if (isset($cart[$key])) {

        unset($cart[$key]);
    }

    // simpan ulang session
    session()->set($sessionKey, $cart);

    return redirect()->to('/cart/' . $id_meja);
}
}
