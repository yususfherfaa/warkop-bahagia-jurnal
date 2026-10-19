<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class RecommendationAcceptance extends BaseController
{
    public function index()
    {
        $rows = [];
        $available = true;
        try {
            $rows = \Config\Database::connect()->table('recommendation_logs')
                ->select('jam, COUNT(*) AS ditampilkan, SUM(id_produk_dipilih IS NOT NULL) AS dipilih', false)
                ->groupBy('jam')
                ->orderBy('jam', 'ASC')
                ->get()->getResultArray();
        } catch (\Throwable $e) {
            $available = false;
        }

        foreach ($rows as &$row) {
            $row['tingkat'] = (int) $row['ditampilkan'] > 0
                ? 100 * (int) $row['dipilih'] / (int) $row['ditampilkan']
                : 0;
        }
        unset($row);

        return view('admin/recommendation_acceptance', [
            'rows' => $rows,
            'available' => $available,
        ]);
    }
}
