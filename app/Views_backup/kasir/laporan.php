<!doctype html>
<html lang="id">
<head>
    <link rel="stylesheet"
    href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">

    <style>
        .container {
            max-width: 1200px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        h2 {
            text-align: center;
            color: #007bff;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table td {
            border-bottom:1px solid #ddd;
            padding: 8px;
        }

        .table th {
            background: #007bff;
            color: white;
            padding:12px;

        }

        .filter-box {
            margin-bottom: 15px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        input, select, button {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #0069d9;
        }

        .summary {
            margin-top: 20px;
            padding: 10px;
            background: #f8fbff;
            border: 1px solid #cce5ff;
            border-radius: 8px;
        }
    </style>
</head>

<body>

<!-- NAVBAR CI4 -->
<?php if(session()->get('role') == 'admin'): ?>

    <?= $this->include('layout/navbar_admin') ?>

<?php else: ?>

    <?= $this->include('layout/navbar_kasir') ?>

<?php endif; ?>

<div class="container">

    <h2>Laporan Penjualan</h2>

    <!-- FILTER -->
    <form method="get" class="filter-box">
        <input type="date" name="from" value="<?= $from ?>">
        <input type="date" name="to" value="<?= $to ?>">
        <?php if(session()->get('role') == 'admin'): ?>

        <select name="id_user">

            <option value="all">
                Semua Kasir
            </option>

            <?php foreach($kasirList as $k): ?>

            <option
                value="<?= $k['id_user'] ?>"
                <?= ($id_user == $k['id_user']) ? 'selected' : '' ?>>

                <?= esc($k['nama_kasir']) ?>

            </option>

            <?php endforeach; ?>

        </select>

    <?php endif; ?>
        <button type="submit"
            class="btn">
        Filter
    </button>

    <a href="<?= base_url(
        'laporan/pdf?from='.$from.
        '&to='.$to.
        '&id_user='.$id_user
    ) ?>"
       class="btn">
       Export PDF
    </a>
    </form>

    <!-- TABLE ORDER -->
    <table class="table" id="tabelLaporan">

    <thead>
        <tr>
            <th>Order ID</th>
            <th>Meja</th>
            <th>Pelanggan</th>
            <th>Kasir</th>
            <th>Metode
            <th>Total</th>
            <th>Waktu</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($orders as $o): ?>
        <tr>
            <td><?= $o['id_order'] ?></td>
            <td><?= $o['id_meja'] ?></td>
            <td><?= $o['nama_pelanggan'] ?></td>
            <td><?= $o['nama_kasir'] ?? '-' ?></td>
            <td><?= ucfirst($o['metode_pembayaran']) ?></td>
            <td>Rp <?= number_format($o['total'],0,',','.') ?></td>
            <td><?= $o['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>

</table>

    <!-- SUMMARY -->
    <div class="summary">
        <p><b>Total Transaksi:</b> <?= count($orders) ?></p>

        <p><b>Total Pendapatan:</b>
            Rp <?= number_format(array_sum(array_column($orders,'total')),0,',','.') ?>
        </p>
    </div>

    <!-- MENU TERJUAL -->
    <h2 style="margin-top:30px;">Menu Terjual</h2>

    <table class="table" id="tabelMenu">

    <thead>
        <tr>
            <th>Nama Menu</th>
            <th>Qty Terjual</th>
            <th>Total Pendapatan</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($menuList as $m): ?>
        <tr>
            <td><?= $m['nama'] ?></td>
            <td><?= $m['total_terjual'] ?></td>
            <td>
                Rp <?= number_format($m['total_pendapatan'],0,',','.') ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>

</table>
<div class="summary">
        <p><b>Menu Terjual:</b> <?= count($menuList) ?></p>
        <p><b>Menu Terlaris:</b>
            <?php if(!empty($menuList)): ?>
                <?= $menuList[0]['nama'] ?> (<?= $menuList[0]['total_terjual'] ?>x)
            <?php endif; ?>
        </p>
    </div>

</div>

</body>
</html>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function(){

    $('#tabelLaporan').DataTable({

        pageLength: 5,

        lengthMenu: [
            [5,10,25,50,100,-1],
            [5,10,25,50,100,'Semua']
        ],

        order: [[0, 'desc']],

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

    $('#tabelMenu').DataTable({

    pageLength: 5,

    lengthMenu: [
        [5,10,25,50,100,-1],
        [5,10,25,50,100,'Semua']
    ],

    order: [[0, 'desc']],

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