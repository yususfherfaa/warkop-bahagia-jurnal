<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pembayaran Pesanan</title>

<link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">

<style>
body{
    font-family:Arial;
    background:#f4f6f9;
    margin:0;
}

.container{
    max-width:900px;
    margin:30px auto;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 2px 8px rgba(0,0,0,0.08);
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
    background:white;
    border-radius:10px;
    overflow:hidden;
}

th,td{
    padding:10px;
    text-align:center;
}

th{
    background:#007bff;
    color:white;
    font-weight:normal;
}

/* TOTAL BOX */
.total-box{
    margin-top:15px;
    padding:15px;
    background:#f1f7ff;
    border-radius:8px;
    font-size:16px;
}

/* INPUT */
input{
    width:100%;
    padding:10px;
    border:1px solid #ddd;
    border-radius:6px;
    margin-top:5px;
}

/* BUTTON */
button{
    margin-top:15px;
    width:100%;
    padding:10px;
    background:#007bff;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

button:hover{
    background:#0069d9;
}

/* ERROR */
.error{
    color:red;
    margin-bottom:10px;
}
</style>

</head>
<body>

<?= $this->include('layout/navbar_kasir') ?>

<div class="container">

<h2 style="font-weight:normal;">Pembayaran Pesanan</h2>

<?php if(session()->getFlashdata('error')): ?>
<p class="error">
    <?= session()->getFlashdata('error') ?>
</p>
<?php endif; ?>

<p><strong>Order ID :</strong> <?= $order['id_order'] ?></p>
<p><strong>Meja :</strong> <?= $order['id_meja'] ?></p>
<p><strong>Pelanggan :</strong> <?= esc($order['nama_pelanggan']) ?></p>

<table>
<tr>
    <th>Menu</th>
    <th>Harga</th>
    <th>Qty</th>
    <th>Subtotal</th>
</tr>

<?php foreach($items as $it): ?>
<tr>
    <td><?= esc($it['nama']) ?></td>
    <td>Rp <?= number_format($it['harga'],0,',','.') ?></td>
    <td><?= $it['qty'] ?></td>
    <td>Rp <?= number_format($it['subtotal'],0,',','.') ?></td>
</tr>
<?php endforeach; ?>

</table>

<div class="total-box">

<strong>Total Pembayaran :</strong>
Rp <?= number_format($order['total'],0,',','.') ?>

<br><br>

<strong>Metode :</strong>
<?= strtoupper($order['metode_pembayaran']) ?>

</div>

<?php if($order['metode_pembayaran'] == 'cash'): ?>

<form method="post"
      action="<?= base_url('/kasir/bayar/process/'.$order['id_order']) ?>">

    <label>CASH</label>

    <input type="number"
           name="uang_dibayar"
           min="<?= $order['total'] ?>"
           placeholder="Masukkan nominal"
           required>

    <button type="submit">
        Proses Pembayaran
    </button>

</form>

<?php else: ?>

<form method="post"
      action="<?= base_url('/kasir/bayar/process/'.$order['id_order']) ?>">

    <input type="hidden"
           name="uang_dibayar"
           value="<?= $order['total'] ?>">

    <div style="
        margin-top:15px;
        padding:15px;
        background:#d4edda;
        border-radius:8px;
        color:#155724;
    ">

        Customer memilih pembayaran QRIS.

        <br><br>

        Pastikan pembayaran sudah masuk
        sebelum melakukan verifikasi.

    </div>

    <button type="submit"
            style="
                background:#28a745;
            ">
        Verifikasi QRIS
    </button>

</form>

<?php endif; ?>

</div>

</body>
</html>