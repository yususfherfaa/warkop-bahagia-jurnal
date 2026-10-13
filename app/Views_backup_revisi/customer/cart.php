<!doctype html>
<html lang="id">

<head>

<meta charset="utf-8">

<title>Keranjang</title>

<link rel="stylesheet"
      href="<?= base_url('assets/style.css') ?>">

<style>

body{
    background:#f5f7fb;
    font-family:Arial;
}

.container{
    max-width:1000px;
    margin:40px auto;
}

.card{
    background:white;
    border-radius:12px;
    padding:25px;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
}

h2{
    text-align:center;
    color:#007bff;
    margin-bottom:25px;
}

.table{
    width:100%;
    border-collapse:collapse;
}

.table th{
    background:#007bff;
    color:white;
    padding:12px;
    font-weight:normal;
}

.table td{
    padding:12px;
    border-bottom:1px solid #eee;
    text-align:center;
}

.table tr:hover{
    background:#f8fbff;
}

.btn-delete{
    background:#dc3545;
    color:white;
    padding:8px 12px;
    border-radius:6px;
    text-decoration:none;
    transition:0.2s;
}

.btn-delete:hover{
    background:#c82333;
}

.total-box{
    margin-top:20px;
    text-align:right;
    font-size:22px;
    color:#333;
}

.form-checkout{
    margin-top:30px;
}

.form-checkout input{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:8px;
    margin-bottom:15px;
    font-size:16px;
}

.btn-checkout{
    width:100%;
    background:#007bff;
    color:white;
    border:none;
    padding:14px;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
    transition:0.2s;
}

.btn-checkout:hover{
    background:#0069d9;
}

.empty{
    text-align:center;
    padding:30px;
    color:#666;
}

</style>

</head>

<body>

<div class="container">

<div class="card">

<h2>Keranjang Pesanan</h2>

<?php if(count($items) > 0): ?>

<table class="table">

<tr>

<th>Menu</th>

<th>Harga</th>

<th>Qty</th>

<th>Subtotal</th>

<th>Aksi</th>

</tr>

<?php foreach ($items as $item): ?>

<tr>

<td>
<?= esc($item['nama']) ?>
</td>

<td>

Rp <?= number_format(
    $item['harga'],
    0,
    ',',
    '.'
) ?>

</td>

<td>

<a href="<?= base_url('/cart/qty/'.$id_meja.'/'.$item['id_produk'].'/minus') ?>">
-
</a>

<?= $item['qty'] ?>

<a href="<?= base_url('/cart/qty/'.$id_meja.'/'.$item['id_produk'].'/plus') ?>">
+
</a>

</td>

<td>

Rp <?= number_format(
    $item['harga'] * $item['qty'],
    0,
    ',',
    '.'
) ?>

</td>

<td>

<a href="<?= base_url('cart/remove/'.$id_meja.'/'.$item['id_produk']) ?>"
   class="btn-delete">

    Hapus

</a>

</td>

</tr>

<?php endforeach; ?>

</table>

<div class="total-box">

<b>
Total:
Rp <?= number_format(
    $total,
    0,
    ',',
    '.'
) ?>
</b>

</div>

<div class="form-checkout">

<form method="post"
      action="<?= base_url('/checkout/'.$id_meja) ?>">

<input type="text"
       name="nama_pelanggan"
       placeholder="Masukkan Nama Pelanggan"
       required>

<div style="
    margin-bottom:20px;
    padding:15px;
    border:1px solid #ddd;
    border-radius:8px;
">

    <b>Metode Pembayaran</b>

    <br><br>

    <label>
        <input type="radio"
               name="metode_pembayaran"
               value="cash"
               checked>

        Tunai
    </label>

    <br><br>

    <label>
        <input type="radio"
               name="metode_pembayaran"
               value="qris">

        QRIS
    </label>

</div>

<button class="btn-checkout"
        type="submit">

Checkout Sekarang

</button>

</form>

</div>

<br>

<a href="<?= base_url('/order/'.$id_meja) ?>"
   class="btn-checkout"
   style="display:block;text-align:center;text-decoration:none">

Tambah Menu

</a>

<?php else: ?>

<div class="empty">

Keranjang masih kosong

</div>

<?php endif; ?>

</div>

</div>

</body>
</html>