<!doctype html>
<html lang="id">

<head>

    <meta charset="utf-8">

    <title>
        Dashboard Admin - <?= esc($nama_warkop) ?>
    </title>

    <link rel="stylesheet"
          href="<?= base_url('assets/style.css') ?>">

<style>

body{
    margin:0;
    font-family: Arial, sans-serif;
    background:#eef5ff;
}

/* NAVBAR */
nav{
    background: linear-gradient(90deg,#007bff,#0056d6);
    color:white;
    padding:18px 30px;
    text-align:center;
    box-shadow:0 2px 10px rgba(0,0,0,0.15);
}

nav h1{
    margin:0;
    font-size:38px;
    font-weight:normal;
}

nav .right{
    margin-top:10px;
}

nav .right span{
    margin-right:15px;
    font-size:18px;
}

nav .right a{
    background:#ff4d4d;
    color:white;
    padding:10px 18px;
    border-radius:8px;
    text-decoration:none;
    font-size:17px;
}

nav .right a:hover{
    background:#e60000;
}

/* CONTAINER */
.container{
    max-width:1200px;
    margin:40px auto;
    padding:20px;
}

.container h2{
    text-align:center;
    color:#007bff;
    margin-bottom:35px;
    font-size:45px;
    font-weight:normal;
}

/* CARD */
.card-container{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(350px,1fr));
    gap:30px;
}

.card{
    background:white;
    border-radius:20px;
    padding:60px 40px;
    text-align:center;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
    transition:0.3s;
    min-height:220px;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.card:hover{
    transform:translateY(-5px);
}

.card h3{
    color:#007bff;
    font-size:28px;
    margin-bottom:30px;
    font-weight:normal;
}

.card p{
    font-size:58px;
    color:#111;
    margin:0;
    font-weight:bold;
}

/* MENU BUTTON */
.menu{
    margin-top:40px;
    text-align:center;
}

.menu a{
    display:inline-block;
    background:#007bff;
    color:white;
    text-decoration:none;
    padding:12px 25px;
    margin:8px;
    border-radius:10px;
    text-align:center;
    font-size:18px;
    transition:0.3s;
    min-width:220px;
}

.menu a:hover{
    background:#0056d6;
}

/* FOOTER */
footer{
    text-align:center;
    padding:25px;
    color:#555;
    font-size:20px;
}

</style>

</head>

<body>

<nav>

    <h1>
        <?= esc($nama_warkop) ?> - Admin
    </h1>

    <div class="right">

        <span>
            👑 Halo, <?= esc(session()->get('nama_kasir')) ?>
        </span>

        <a href="<?= base_url('/logout') ?>">
            Logout
        </a>

    </div>

</nav>

<div class="container">

    <h2>Dashboard Admin</h2>

    <div class="stats">

        <div class="stat-card">

            <h3>Total Pesanan Hari Ini</h3>

            <p><?= $total_pesanan ?></p>

        </div>

        <div class="stat-card">

            <h3>Total Pendapatan Hari Ini</h3>

            <p>
                Rp
                <?= number_format(
                    $total_pendapatan,
                    0,
                    ',',
                    '.'
                ) ?>
            </p>

        </div>

        <div class="stat-card">

            <h3>Total Kasir</h3>

            <p><?= $jumlah_kasir ?></p>

        </div>

        <div class="stat-card">

            <h3>Total Menu</h3>

            <p><?= $jumlah_produk ?></p>

        </div>

    </div>

    <div class="menu">

    <a href="<?= base_url('/admin/kasir') ?>">
        Kelola Kasir
    </a>

    <a href="<?= base_url('/laporan') ?>">
        Laporan Penjualan
    </a>

    <a href="<?= base_url('/laporan-stok') ?>">
        Laporan Stok & Menu
    </a>

    <a href="<?= base_url('/admin/settings') ?>">
        Pengaturan
    </a>

</div>

</div>

<footer>

© <?= date('Y') ?>

<?= esc($nama_warkop) ?>

— Dashboard Admin

</footer>

</body>
</html>