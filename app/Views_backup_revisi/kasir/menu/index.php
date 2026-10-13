<!doctype html>
<html lang="id">

<head>

<meta charset="utf-8">
<title>Menu Kasir</title>

<link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">

<style>

body{
    margin:0;
    font-family:Arial;
    background:#f4f6f9;
}

.container{
    padding:20px;
}

/* TITLE */
h2{
    margin-bottom:15px;
}

/* FORM */
.form-box{
    background:white;
    padding:15px;
    border-radius:10px;
    box-shadow:0 2px 8px rgba(0,0,0,0.08);
    margin-bottom:20px;
}

.form-box input{
    padding:10px;
    margin:5px;
    width:180px;
    border:1px solid #ddd;
    border-radius:6px;
}

.form-box select{
    padding:10px;
    margin:5px;
    width:180px;
    border:1px solid #ddd;
    border-radius:6px;
}


.btn-add{
    padding:10px 18px;
    background:#007bff;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

/* GRID CARD */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fill, minmax(220px, 1fr));
    gap:15px;
}

.card{
    background:white;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 2px 8px rgba(0,0,0,0.08);
    transition:0.2s;
    font-weight: normal; /* penting biar semua isi card default normal */
}

.card:hover{
    transform:scale(1.02);
}

.card img{
    width:100%;
    height:140px;
    object-fit:cover;
}

.card-body{
    padding:12px;
    font-weight: normal;
}

.card h3{
    font-weight: normal;
    margin:0 0 5px 0;
}

/* BUTTON SAMA STYLE ADMIN */
.btn-edit{
    background:#28a745;
    color:white;
    padding:6px 10px;
    border-radius:5px;
    text-decoration:none;
    font-size:12px;
    margin-right:5px;
}

.btn-delete{
    background:#dc3545;
    color:white;
    padding:6px 10px;
    border-radius:5px;
    text-decoration:none;
    font-size:12px;
}

.small{
    font-size:12px;
    color:#666;
}

</style>

</head>

<body>

<!-- NAVBAR -->
<?= $this->include('layout/navbar_kasir') ?>

<div class="container">

<h2>Menu Kasir</h2>

<!-- FORM TAMBAH -->
<div class="form-box">

<form method="post"
      action="<?= base_url('/kasir/menu/add') ?>"
      enctype="multipart/form-data">

    <input type="text" name="nama" placeholder="Nama Produk" required>

    <select name="kategori" required>
    <option value="">Pilih Kategori</option>
    <option value="Makanan Berat">Makanan Berat</option>
    <option value="Cemilan">Cemilan</option>
    <option value="Minuman Kopi">Minuman Kopi</option>
    <option value="Minuman Non Kopi">Minuman Non Kopi</option>
</select>

    <input type="number" name="harga" placeholder="Harga" required>

    <input type="number" name="stok" placeholder="Stok" required>

    <input type="file" name="gambar" required>

    <button type="submit" class="btn-add">+ Tambah</button>

</form>

</div>

<!-- CARD GRID -->
<div class="grid">

<?php foreach ($products as $p): ?>

    <div class="card">

        <img src="<?= base_url('uploads/'.$p['gambar']) ?>">

        <div class="card h3">

            <h3><?= esc($p['nama']) ?></h3>

            <div class="small">
                <?= esc($p['kategori']) ?>
            </div>

            <div class="price">
                Rp <?= number_format($p['harga'], 0, ',', '.') ?>
            </div>

            <div class="small">
                Stok: <?= $p['stok'] > 0 ? esc($p['stok']) : '<span style="color:#dc3545;font-weight:bold;">Habis</span>' ?>
            </div>

            <br>

            <a class="btn-edit"
               href="<?= base_url('/kasir/menu/edit/'.$p['id_produk']) ?>">
                  Edit
            </a>

            <a class="btn-delete"
               href="<?= base_url('/kasir/menu/delete/'.$p['id_produk']) ?>"
               onclick="return confirm('Hapus produk ini?')">
               Hapus
            </a>

        </div>

    </div>

<?php endforeach; ?>

</div>

</div>

</body>
</html>