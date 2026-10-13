<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    protected $allowedFields = [
        'nama_produk',
        'harga',
        'gambar'
    ];
}