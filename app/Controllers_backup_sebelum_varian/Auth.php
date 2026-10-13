<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SettingModel;

class Auth extends BaseController
{
    public function index()
    {
        $settingModel = new SettingModel();

        $settings = [];

        foreach ($settingModel->findAll() as $s) {
            $settings[$s['nama']] = $s['value'];
        }

        $data = [
            'msg' => session()->getFlashdata('msg'),

            'nama_warkop' => $settings['nama_warkop'] ?? 'Warkop Bahagia',

            'alamat' => $settings['alamat'] ?? 'Alamat belum diatur',

            'kontak' => $settings['kontak'] ?? '-',

            'logo' => $settings['logo'] ?? 'uploads/default-logo.png',
        ];

        return view('auth/login', $data);
    }

    public function processLogin()
    {
        $userModel = new UserModel();

        $username = $this->request->getPost('username');

        $password = $this->request->getPost('password');

        $user = $userModel
            ->where('username', $username)
            ->first();

        if ($user && password_verify($password, $user['password'])) {

            session()->set([
                'id_user'     => $user['id_user'],
                'username'    => $user['username'],
                'role'        => $user['role'],
                'nama_kasir'  => $user['nama_kasir'],
                'logged_in'   => true
            ]);

            if ($user['role'] === 'admin') {
                return redirect()->to('/admin/dashboard');
            }

            return redirect()->to('/kasir/dashboard');
        }

        return redirect()
            ->back()
            ->with('msg', 'Username / Password salah');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/');
    }
}