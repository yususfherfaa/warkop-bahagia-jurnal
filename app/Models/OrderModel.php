<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id_order';

    protected $allowedFields = [
        'id_order',
        'id_meja',
        'nama_pelanggan',
        'status',
        'total',
        'payment_id',
        'created_at'
    ];
}