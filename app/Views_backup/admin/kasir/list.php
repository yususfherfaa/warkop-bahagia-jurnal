<!doctype html>
<html lang="id">

<head>

<meta charset="utf-8">

<title>Daftar Kasir</title>

<link rel="stylesheet"
      href="<?= base_url('assets/style.css') ?>">

<style>

.table {
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
    background:white;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 2px 8px rgba(0,0,0,0.08);
}

.table th {
    background:#007bff;
    color:white;
    padding:12px;
    text-align:center;
    font-weight:normal;
}

.table td {
    padding:12px;
    border-bottom:1px solid #eee;
    text-align:center;
}

.table tr:hover {
    background:#f5faff;
}

.btn-add {
    display:inline-block;
    padding:10px 18px;
    background:#007bff;
    color:white;
    text-decoration:none;
    border-radius:6px;
    margin-bottom:15px;
    transition:0.2s;
}

.btn-add:hover {
    background:#0069d9;
}

.btn-edit {
    background:#28a745;
    color:white;
    padding:6px 12px;
    border-radius:5px;
    text-decoration:none;
    margin-right:5px;
}

.btn-edit:hover {
    background:#218838;
}

.btn-delete {
    background:#dc3545;
    color:white;
    padding:6px 12px;
    border-radius:5px;
    text-decoration:none;
}

.btn-delete:hover {
    background:#c82333;
}

</style>

</head>

<body>

<?= $this->include('layout/navbar_admin') ?>

<div class="container">

<h2>Daftar Kasir</h2>

<a href="<?= base_url('admin/kasir/add') ?>"
   class="btn-add">
   + Tambah Kasir
</a>

<table class="table">

<tr>
    <th>ID Kasir</th>
    <th>Nama Kasir</th>
    <th>Username</th>
    <th>Aksi</th>
</tr>

<?php foreach ($kasir as $k): ?>

<tr>

    <td>
        <?= esc($k['id_user']) ?>
    </td>

    <td>
        <?= esc($k['nama_kasir']) ?>
    </td>

    <td>
        <?= esc($k['username']) ?>
    </td>

    <td>

        <a href="<?= base_url('admin/kasir/edit/'.$k['id_user']) ?>"
           class="btn-edit">
           Edit
        </a>

        <a href="<?= base_url('admin/kasir/delete/'.$k['id_user']) ?>"
           class="btn-delete"
           onclick="return confirm('Hapus kasir ini?')">
           Hapus
        </a>

    </td>

</tr>

<?php endforeach; ?>

</table>

</div>

</body>
</html>