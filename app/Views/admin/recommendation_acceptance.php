<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tingkat Penerimaan Rekomendasi</title>
    <link rel="stylesheet" href="<?= base_url('assets/theme.css') ?>">
</head>
<body>
<?= view('layout/navbar_admin') ?>
<main class="container" style="max-width:1000px;padding:24px 16px;">
    <h1>Tingkat penerimaan rekomendasi</h1>
    <p>Jumlah produk yang dipilih dari setiap rekomendasi yang ditampilkan, dikelompokkan menurut jam.</p>
    <?php if (!$available): ?>
        <div role="status">Tabel log belum tersedia. Terapkan migrasi recommendation logs secara manual untuk mengaktifkan laporan.</div>
    <?php elseif ($rows === []): ?>
        <p>Belum ada log rekomendasi.</p>
    <?php else: ?>
        <div class="card" style="overflow-x:auto;padding:16px;">
            <table style="width:100%;border-collapse:collapse;">
                <thead><tr><th>Jam</th><th>Ditampilkan</th><th>Dipilih</th><th>Tingkat penerimaan</th></tr></thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?= esc(str_pad((string) $row['jam'], 2, '0', STR_PAD_LEFT)) ?>.00</td>
                            <td><?= esc((string) $row['ditampilkan']) ?></td>
                            <td><?= esc((string) $row['dipilih']) ?></td>
                            <td><?= esc(number_format((float) $row['tingkat'], 1, ',', '.')) ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>
</body>
</html>
