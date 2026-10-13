<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class Setting extends BaseController
{
    public function index()
    {
        $model = new SettingModel();

        $settings = $model->findAll();

        $data = [];

        foreach ($settings as $s) {
            $data[$s['nama']] = $s['value'];
        }

        return view('admin/settings', [
            'settings' => $data
        ]);
    }

    public function update()
    {
        $model = new SettingModel();

        $fields = [
            'nama_warkop',
            'alamat',
            'kontak',
            'server_url',
        ];

        foreach ($fields as $f) {

            $value = $this->request->getPost($f);

            $existing = $model
                ->where('nama', $f)
                ->first();

            if ($existing) {

                $model->update($existing['id_setting'], [
                    'value' => $value
                ]);

            } else {

    $last = $model
        ->orderBy('id_setting', 'DESC')
        ->first();

    $next = $last
        ? ((int) substr($last['id_setting'], 3) + 1)
        : 1;

    $id_setting = 'SET' . str_pad($next, 3, '0', STR_PAD_LEFT);

    $model->insert([
        'id_setting' => $id_setting,
        'nama'       => $f,
        'value'      => $value
    ]);
}
        }

        /* =========================
           UPLOAD LOGO
        ========================= */

        $file = $this->request->getFile('logo');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            $namaFile = $file->getRandomName();

            $file->move(ROOTPATH . 'public/uploads', $namaFile);

            $pathLogo = 'uploads/' . $namaFile;

            $existingLogo = $model
                ->where('nama', 'logo')
                ->first();

            if ($existingLogo) {

                $model->update($existingLogo['id_setting'], [
                    'value' => $pathLogo
                ]);

            } else {

                $last = $model
    ->orderBy('id_setting', 'DESC')
    ->first();

$next = $last
    ? ((int) substr($last['id_setting'], 3) + 1)
    : 1;

$id_setting = 'SET' . str_pad($next, 3, '0', STR_PAD_LEFT);

$model->insert([
    'id_setting' => $id_setting,
    'nama'       => 'logo',
    'value'      => $pathLogo
]);
            }
            }

            $qris = $this->request->getFile('qris');

        if ($qris && $qris->isValid() && !$qris->hasMoved()) {

            $namaFile = 'qris.png';

            $qris->move(
            FCPATH.'uploads',
            $namaFile,
            true
            );

            }

            return redirect()
            ->to('/admin/settings')
            ->with('success', 'Settings berhasil disimpan');
    }

    public function qrMeja()
{
    $db = \Config\Database::connect();

    $settingModel = new \App\Models\SettingModel();

    $server = $settingModel
        ->where('nama','server_url')
        ->first();

    $serverUrl = $server['value'] ?? '';

    $meja = $db->table('tables_meja')
        ->orderBy('id_meja','ASC')
        ->get()
        ->getResultArray();

    return view('admin/qr_meja',[
        'meja' => $meja,
        'serverUrl' => $serverUrl
    ]);
}
    
}