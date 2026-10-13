<!doctype html>
<html lang="id">

<head>

<meta charset="utf-8">

<title>
Daftar Pesanan
</title>

<link rel="stylesheet"
      href="<?= base_url('assets/style.css') ?>">

<style>

body{
    font-family:Arial;
    background:#f7faff;
}

.container{
    max-width:1200px;
    margin:20px auto;
    background:#fff;
    padding:25px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
    
}

th,td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #eee;
}

th{
    background:#007bff;
    color:#fff;
    font-weight:normal;
}

tr:hover{
    background:#f5faff;
}

.btn{
    padding:6px 10px;
    border-radius:5px;
    color:#fff;
    text-decoration:none;
    font-size:13px;
    margin:2px;
    display:inline-block;
}

.btn-detail{
    background:#007bff;
}

.btn-bayar{
    background:#28a745;
}

.btn:hover{
    opacity:0.85;
}

.status{
    font-weight:normal;
    padding:5px 10px;
    border-radius:5px;
    display:inline-block;
}

.status.lunas{
    background:#eafaf1;
    color:#28a745;
}

.status.menunggu{
    background:#fff4e5;
    color:#e67e22;
}

</style>

</head>

<body>

<?= $this->include('layout/navbar_kasir') ?>

<div class="container">

<h2>
Daftar Pesanan
</h2>

<table>

<tr>

<th>Order ID</th>
<th>Meja</th>
<th>Pelanggan</th>
<th>Status</th>
<th>Total</th>
<th>Waktu</th>
<th>Aksi</th>

</tr>

<?php foreach($orders as $o): ?>

<tr>

<td>
#<?= esc($o['id_order']) ?>
</td>

<td>
<?= esc($o['id_meja']) ?>
</td>

<td>
<?= esc($o['nama_pelanggan']) ?>
</td>

<td class="
status
<?= $o['payment_id']
    ? 'lunas'
    : 'menunggu' ?>
">

<?= $o['payment_id']
    ? 'Lunas'
    : 'Menunggu Pembayaran' ?>

</td>

<td>

Rp
<?= number_format(
    $o['total'],
    0,
    ',',
    '.'
) ?>

</td>

<td>
<?= esc($o['created_at']) ?>
</td>

<td>

<a class="btn btn-detail"

href="<?= base_url(
'/kasir/detail-pesanan/'
.$o['id_order']
) ?>">

Detail

</a>

<?php if(!$o['payment_id']): ?>

<a class="btn btn-bayar"

href="<?= base_url(
'/kasir/bayar/'
.$o['id_order']
) ?>">

Bayar

</a>

<?php else: ?>

<a class="btn btn-detail"

href="<?= base_url(
'/kasir/struk/'
.$o['id_order']
) ?>">

Struk

</a>

<?php endif; ?>

</td>

</tr>

<?php endforeach; ?>

</table>

</div>

</body>
</html>