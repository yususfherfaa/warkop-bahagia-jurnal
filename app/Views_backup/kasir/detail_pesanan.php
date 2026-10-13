<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<title>Detail Pesanan</title>

<link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">

<style>

/* GLOBAL DASHBOARD STYLE */
body{
    font-family:Arial;
    background:#f4f6f9;
    margin:0;
}

/* CONTAINER CARD */
.container{
    max-width:1100px;
    margin:20px auto;
    background:#fff;
    padding:25px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
}

/* BACK BUTTON */
.btn{
    display:inline-block;
    padding:8px 12px;
    border-radius:5px;
    text-decoration:none;
    color:#fff;
    background:#007bff;
    font-size:14px;
    margin-bottom:10px;
}

.btn:hover{
    opacity:0.85;
}

/* TITLE */
h2, h3{
    font-weight:normal;
}

/* INFO TEXT */
p{
    margin:5px 0;
}

/* TABLE DASHBOARD */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
    background:white;
    border-radius:8px;
    overflow:hidden;
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

/* SUMMARY BOX */
.summary{
    margin-top:20px;
    text-align:right;
    font-size:16px;
    padding:12px;
    background:#f8f9fa;
    border-radius:8px;
}

/* PAYMENT BOX */
.payment-box{
    margin-top:20px;
    padding:15px;
    background:#f8f9fa;
    border-radius:8px;
}

.payment-box p{
    margin:6px 0;
}

</style>

</head>

<body>

<?= $this->include('layout/navbar_kasir') ?>

<div class="container">

<a class="btn" href="<?= base_url('/kasir/pesanan') ?>">
    ← Kembali
</a>

<h2>
Detail Pesanan #<?= esc($order['id_order']) ?>
</h2>

<p><strong>Meja :</strong> <?= esc($order['id_meja']) ?></p>
<p><strong>Pelanggan :</strong> <?= esc($order['nama_pelanggan']) ?></p>

<p>
<strong>Status :</strong>
<?= ucfirst(str_replace('_',' ',$order['status'])) ?>
</p>

<!-- TABLE ITEM -->
<table>

<tr>
    <th>Menu</th>
    <th>Qty</th>
    <th>Harga</th>
    <th>Subtotal</th>
</tr>

<?php foreach($items as $i): ?>
<tr>
    <td><?= esc($i['nama']) ?></td>
    <td><?= esc($i['qty']) ?></td>
    <td>Rp <?= number_format($i['harga'],0,',','.') ?></td>
    <td>Rp <?= number_format($i['subtotal'],0,',','.') ?></td>
</tr>
<?php endforeach; ?>

</table>

<!-- TOTAL -->
<div class="summary">
    Total Pesanan :
    Rp <?= number_format($order['total'],0,',','.') ?>
</div>

<!-- PAYMENT -->
<div class="payment-box">

<h3>Informasi Pembayaran</h3>

<?php if($payment): ?>

<p><strong>Metode :</strong> <?= esc($payment['metode_pembayaran']) ?></p>
<p><strong>Cash :</strong> Rp <?= number_format($payment['uang_dibayar'],0,',','.') ?></p>
<p><strong>Kembalian :</strong> Rp <?= number_format($payment['kembalian'],0,',','.') ?></p>

<?php else: ?>

<p style="color:#e74c3c;">
    Belum ada pembayaran
</p>

<?php endif; ?>

</div>

</div>

</body>
</html>