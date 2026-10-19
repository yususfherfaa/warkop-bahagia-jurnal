<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Stok — <?= esc(setting('nama_warkop') ?? 'Warkop Bahagia') ?></title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/theme.css') ?>">
    <style>
    .card-table-wrap {
        background: var(--ivory);
        border: 1px solid var(--sand);
        border-radius: var(--r-xl);
        padding: var(--sp-6);
        box-shadow: var(--shadow-md);
        margin-top: var(--sp-5);
    }
    .badge-stok {
        display: inline-block;
        padding: 4px 10px;
        border-radius: var(--r-pill);
        font-size: var(--fs-xs);
        font-weight: 700;
    }
    .badge-stok.aman { background: var(--sage-light); color: var(--sage); }
    .badge-stok.menipis { background: var(--amber-light); color: var(--amber); }
    .badge-stok.habis { background: var(--brick-light); color: var(--brick); }

    /* DataTables Beige Styling */
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        border: 1.5px solid var(--beige) !important;
        border-radius: var(--r-input) !important;
        padding: 6px 12px !important;
        background: var(--ivory) !important;
        color: var(--espresso) !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--terracotta) !important;
        color: #fff !important;
        border: none !important;
        border-radius: var(--r-sm) !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: var(--sand) !important;
        color: var(--espresso) !important;
        border: none !important;
    }
    table.dataTable thead th {
        background: var(--espresso) !important;
        color: var(--cream) !important;
        font-family: var(--font-body);
        font-weight: 600;
        border-bottom: none !important;
        padding: 12px 14px;
    }
    table.dataTable tbody td {
        padding: 12px 14px;
        border-bottom: 1px solid var(--sand);
        background: var(--ivory);
        color: var(--espresso);
    }
    table.dataTable tbody tr:hover td {
        background: rgba(226, 205, 177, 0.25) !important;
    }
    </style>
</head>
<body>

<?= $this->include('layout/navbar_admin') ?>

<div class="container reveal">

    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
        <div>
            <h1 style="margin:0;">Laporan Stok & Menu</h1>
            <p class="text-muted" style="margin:4px 0 0 0;">Monitoring persediaan bahan dan stok menu di <?= esc(setting('nama_warkop') ?? 'Warkop Bahagia') ?></p>
        </div>
        <div>
            <a href="<?= base_url('kasir/menu') ?>" class="btn btn-sm">
                ☕ Tambah / Kelola Menu
            </a>
        </div>
    </div>

    <div class="card-table-wrap">

        <table id="tabelStok" class="display" style="width:100%;">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>ID Produk</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok Saat Ini</th>
                    <th>Status Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($produk as $p): ?>
                <tr>
                    <td style="text-align:center;">
                        <img src="<?= base_url('uploads/'.$p['gambar']) ?>"
                             alt="<?= esc($p['nama']) ?>"
                             style="width:48px; height:48px; object-fit:cover; border-radius:var(--r-sm); border:1px solid var(--sand);"
                             onerror="this.src='<?= base_url('assets/noimage.png') ?>'">
                    </td>
                    <td><code><?= esc($p['id_produk']) ?></code></td>
                    <td><strong><?= esc($p['nama']) ?></strong></td>
                    <td><?= esc($p['kategori']) ?></td>
                    <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                    <td style="font-weight:700;"><?= (int)$p['stok'] ?></td>
                    <td>
                        <?php if($p['stok'] <= 0): ?>
                            <span class="badge-stok habis">Habis (0)</span>
                        <?php elseif($p['stok'] <= 5): ?>
                            <span class="badge-stok menipis">Menipis (<?= (int) $p['stok'] ?>)</span>
                        <?php else: ?>
                            <span class="badge-stok aman">Tersedia</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</div>

<footer style="text-align:center; padding:var(--sp-8); color:var(--taupe); font-size:var(--fs-sm);">
    © <?= date('Y') ?> <?= esc(setting('nama_warkop') ?? 'Warkop Bahagia') ?>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/theme.js') ?>"></script>
<script>
$(document).ready(function(){
    $('#tabelStok').DataTable({
        pageLength: 10,
        language: {
            search: 'Cari:',
            lengthMenu: 'Tampilkan _MENU_ menu',
            info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ menu',
            paginate: { previous: 'Sebelumnya', next: 'Berikutnya' }
        }
    });
});
</script>
</body>
</html>