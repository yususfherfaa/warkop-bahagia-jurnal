<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id_produk';

    protected $allowedFields = [
        'id_produk',
        'nama',
        'kategori',
        'harga',
        'stok',
        'varian_suhu',
        'tambahan_harga_es',
        'gambar',
        'suhu_tetap',
        'punya_opsi',
        'label_opsi',
        'deskripsi',
    ];
}