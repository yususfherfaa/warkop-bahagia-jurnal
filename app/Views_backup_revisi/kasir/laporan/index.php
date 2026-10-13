<!doctype html>
<html lang="id">

<head>

<link rel="stylesheet"
href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

<meta charset="utf-8">

<title>Laporan Penjualan</title>

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

.filter-box {
    background:white;
    padding:20px;
    border-radius:10px;
    margin-bottom:20px;
    box-shadow:0 2px 8px rgba(0,0,0,0.08);
}

.filter-box form {
    display:flex;
    gap:10px;
    flex-wrap:wrap;
    align-items:center;
}

.filter-box input,
.filter-box select {
    padding:10px;
    border:1px solid #ddd;
    border-radius:6px;
}

.btn {
    background:#007bff;
    color:white;
    padding:10px 16px;
    border:none;
    border-radius:6px;
    text-decoration:none;
    cursor:pointer;
}

.btn:hover {
    background:#0069d9;
}

.summary {
    margin-top:20px;
    background:#f5faff;
    padding:15px;
    border-radius:10px;
}

.summary p {
    margin:8px 0;
}

</style>

</head>

<body>

<?php if(session()->get('role') == 'admin'): ?>

    <?= $this->include('layout/navbar_admin') ?>

<?php else: ?>

    <?= $this->include('layout/navbar_kasir') ?>

<?php endif; ?>

<div class="container">

<h2>Laporan Penjualan</h2>

<div class="filter-box">

<form method="get">

    <input type="date"
           name="from"
           value="<?= $from ?>">

    <input type="date"
           name="to"
           value="<?= $to ?>">

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

</div>

<table class="table" id="tabelLaporan">

<thead>
<tr>

    <th>Order ID</th>
    <th>Meja</th>
    <th>Pelanggan</th>

    <?php if(session()->get('role') == 'admin'): ?>
        <th>Kasir</th>
    <?php endif; ?>

    <th>Total</th>
    <th>Tanggal</th>

</tr>
</thead>

<tbody>

<?php foreach($orders as $o): ?>

<tr>

    <td><?= esc($o['id_order']) ?></td>

    <td><?= esc($o['id_meja']) ?></td>

    <td><?= esc($o['nama_pelanggan']) ?></td>

    <?php if(session()->get('role') == 'admin'): ?>
        <td><?= esc($o['nama_kasir']) ?></td>
    <?php endif; ?>

    <td>
        Rp <?= number_format($o['total'],0,',','.') ?>
    </td>

    <td><?= $o['created_at'] ?></td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

<div class="summary">

<p>
<b>Total Pesanan :</b>
<?= $total_pesanan ?>
</p>

<p>
<b>Total Pendapatan :</b>
Rp <?= number_format(
    $total_pendapatan,
    0,
    ',',
    '.'
) ?>
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

        language:{
            search:'Cari:',
            lengthMenu:'Tampilkan _MENU_ data',
            info:'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
            paginate:{
                previous:'Sebelumnya',
                next:'Berikutnya'
            }
        }

    });

});
</script>