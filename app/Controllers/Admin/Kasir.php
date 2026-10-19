<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Kasir extends BaseController
{
    public function index()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        $db = \Config\Database::connect();

        $kasirBuilder = $db->table('users')->where('role', 'kasir');
        if ($db->fieldExists('aktif', 'users')) {
            $kasirBuilder->where('aktif', 1);
        }
        $kasir = $kasirBuilder->get()->getResultArray();

        return view('admin/kasir/list', [
            'kasir' => $kasir
        ]);
    }

    public function add()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        return view('admin/kasir/add');
    }

    public function save()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        $db = \Config\Database::connect();

        // ambil ID terakhir
        $last = $db->table('users')
            ->select('id_user')
            ->like('id_user', 'USR')
            ->orderBy('id_user', 'DESC')
            ->get()
            ->getRowArray();

        if ($last) {
            $num = (int) substr($last['id_user'], 3);
            $num++;
        } else {
            $num = 1;
        }

        // seragamkan format ID: USR + 7 digit angka
        $id_user = 'USR' . str_pad($num, 7, '0', STR_PAD_LEFT);

        // insert kasir
        $db->table('users')->insert([

            'id_user'     => $id_user,

            'nama_kasir'  => $this->request->getPost('nama'),

            'username'    => $this->request->getPost('username'),

            'password'    => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),

            'role'        => 'kasir'
        ]);

        return redirect()->to('/admin/kasir/list');
    }

    public function edit($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        $db = \Config\Database::connect();

        $kasir = $db->table('users')
            ->where('id_user', $id)
            ->where('role', 'kasir')
            ->get()
            ->getRowArray();

        if (!$kasir) {
            return redirect()->to('/admin/kasir/list');
        }

        return view('admin/kasir/edit', [
            'kasir' => $kasir
        ]);
    }

    public function update($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        $db = \Config\Database::connect();

        $data = [

            'nama_kasir' => $this->request->getPost('nama'),

            'username'   => $this->request->getPost('username')

        ];

        // update password jika diisi
        $password = $this->request->getPost('password');

        if (!empty($password)) {

            $data['password'] = password_hash(
                $password,
                PASSWORD_DEFAULT
            );
        }

        $db->table('users')
            ->where('id_user', $id)
            ->update($data);

        return redirect()->to('/admin/kasir/list');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        $db = \Config\Database::connect();

        if ($db->fieldExists('aktif', 'users')) {
            $db->table('users')
                ->where('id_user', $id)
                ->update(['aktif' => 0]);
        } else {
            $db->table('users')
                ->where('id_user', $id)
                ->delete();
        }

        return redirect()->to('/admin/kasir/list');
    }
}