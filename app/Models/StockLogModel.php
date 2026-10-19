<?php

namespace App\Models;

use CodeIgniter\Model;

class StockLogModel extends Model
{
    protected $table = 'stock_logs';
    protected $primaryKey = 'id_log';

    protected $allowedFields = [
        'id_log',
        'id_produk',
        'change_qty',
        'id_order',
        'keterangan',
        'created_at'
    ];
}
