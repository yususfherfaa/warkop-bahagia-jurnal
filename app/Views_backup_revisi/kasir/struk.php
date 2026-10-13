<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">

<title>Struk Pembayaran</title>

<style>

body{
    font-family:monospace;
    width:300px;
    margin:auto;
}

h2,p{
    text-align:center;
    margin:4px 0;
}

hr{
    border:none;
    border-top:1px dashed #000;
}

table{
    width:100%;
    font-size:13px;
}

.right{
    text-align:right;
}

.center{
    text-align:center;
}

</style>

</head>

<body onload="window.print()">

<h2><?= setting('nama_warkop') ?></h2>
<p><?= setting('alamat') ?></p>
<p><?= setting('kontak') ?></p>

<hr>

<p style="text-align:left">

No. Order :
<?= $order['id_order'] ?>

<br>

Tanggal :
<?= $order['created_at'] ?>

<br>

Kasir :
<?= esc($payment['nama_kasir'] ?? '-') ?>

<br>

Meja :
<?= esc($order['id_meja']) ?>

<br>

Pelanggan :
<?= esc($order['nama_pelanggan']) ?>

</p>

<hr>

<table>

<?php foreach($items as $i): ?>

<tr>

<td>
<?= esc($i['nama']) ?> x<?= $i['qty'] ?>
</td>

<td class="right">
Rp <?= number_format($i['subtotal'],0,',','.') ?>
</td>

</tr>

<?php endforeach; ?>

</table>

<hr>

<table>

<tr>

<td>
<strong>TOTAL</strong>
</td>

<td class="right">
<strong>
Rp <?= number_format($order['total'],0,',','.') ?>
</strong>
</td>

</tr>

<tr>

<td>
<?= strtoupper($payment['metode_pembayaran'] ?? 'CASH') ?>
</td>

<td class="right">
Rp <?= number_format($payment['uang_dibayar'] ?? 0,0,',','.') ?>
</td>

</tr>

<tr>

<td>KEMBALIAN</td>

<td class="right">
Rp <?= number_format($payment['kembalian'] ?? 0,0,',','.') ?>
</td>

</tr>

</table>

<hr>

<p class="center">

Terima kasih 🙏

<br>

<?= setting($nama_warkop) ?>

</p>

</body>
</html>

<script>

setTimeout(function(){

    window.location.href =
    "<?= base_url('/kasir/pesanan') ?>";

}, 5000);

</script>