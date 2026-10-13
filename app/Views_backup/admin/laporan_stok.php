<!doctype html>
<html lang="id">
<head>

<link rel="stylesheet"
href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

<meta charset="utf-8">

<title>Laporan Stok</title>

<link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">

<style>

body{
    font-family:Arial;
    background:#f5f7fb;
    margin:0;
}

.container{
    max-width:1200px;
    margin:30px auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.card{
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
    margin-bottom:20px;
}

h2{
    color:#007bff;
    text-align: center;
    margin-bottom:20px;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top: 15px;
}

th{
    background:#007bff;
    color:white;
    padding:12px;
}

td{
    padding:8px;
    border-bottom:1px solid #ddd;
}

tr:hover{
    background:#f8fbff;
}

.stok-aman{
    color:green;
}

.stok-tipis{
    color:red;
}

.btn{
    display:inline-block;
    margin-top:20px;
    background:#007bff;
    color:white;
    text-decoration:none;
    padding:10px 15px;
    border-radius:8px;
}

.info{
    color:#666;
    padding:15px;
}

</style>

</head>

<body>

<?= $this->include('layout/navbar_admin') ?>

<div class="container">

<!-- DATA STOK -->

<div class="card">

<h2>Laporan Stok</h2>

<div style="margin-bottom: 15px;">
<a href="<?= base_url('laporan-stok/pdf') ?>"
   target="_blank"
   class="btn">

Export PDF

</a>
</div>

<table id="tabelStok" class="table">

<thead>
<tr>
    <th>ID Produk</th>
    <th>Nama</th>
    <th>Kategori</th>
    <th>Harga</th>
    <th>Stok</th>
</tr>
</thead>

<tbody>

<?php foreach($produk as $p): ?>

<tr>

<td><?= esc($p['id_produk']) ?></td>

<td><?= esc($p['nama']) ?></td>

<td><?= esc($p['kategori']) ?></td>

<td>
Rp <?= number_format($p['harga'],0,',','.') ?>
</td>

<td>

<?php if($p['stok'] <= 0): ?>

<span class="stok-tipis">Habis</span>

<?php elseif($p['stok'] <= 5): ?>

<span class="stok-tipis">
<?= $p['stok'] ?>
</span>

<?php else: ?>

<span class="stok-aman">
<?= $p['stok'] ?>
</span>

<?php endif; ?>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

<!-- AKTIVITAS PRODUK -->

<div class="card">

<h2>Laporan Menu</h2>

<table class="table" id="tabelAktivitas">

<thead>
<tr>
    <th>Tanggal</th>
    <th>Kasir</th>
    <th>Aktivitas</th>
    <th>ID Produk</th>
    <th>Nama Produk</th>
</tr>
</thead>

<tbody>

<?php if(!empty($aktivitas)): ?>

<?php foreach($aktivitas as $a): ?>

<tr>
    <td><?= date('d-m-Y H:i', strtotime($a['created_at'])) ?></td>
    <td><?= esc($a['nama_kasir']) ?></td>
    <td><?= esc($a['aktivitas']) ?></td>
    <td><?= esc($a['id_produk']) ?></td>
    <td><?= esc($a['nama_produk']) ?></td>
</tr>

<?php endforeach; ?>

<?php endif; ?>

</tbody>

</table>

</div>

</div>

</body>
</html>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function(){

    $('#tabelStok').DataTable({

        pageLength: 5,

        lengthMenu: [
            [5,10,25,50,100,-1],
            [5,10,25,50,100,'Semua']
        ],

        language:{
            search:'Cari',
            lengthMenu:'Tampilkan _MENU_',
            info:'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
            paginate:{
                previous:'Sebelumnya',
                next:'Berikutnya'
            }
        }

    });

    $('#tabelAktivitas').DataTable({

        pageLength: 5,

        lengthMenu: [
            [5,10,25,50,100,-1],
            [5,10,25,50,100,'Semua']
        ],

        language:{
            search:'Cari',
            lengthMenu:'Tampilkan _MENU_',
            info:'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
            paginate:{
                previous:'Sebelumnya',
                next:'Berikutnya'
            }
        }

    });

});
</script>