<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Pembayaran QRIS — <?= esc(setting('nama_warkop') ?? 'Warkop Bahagia') ?></title>
<link rel="stylesheet" href="<?= base_url('assets/theme.css') ?>">
<style>
.qris-card {
    background: var(--ivory);
    padding: var(--sp-8);
    border-radius: var(--r-xl);
    text-align: center;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--sand);
    max-width: 520px;
    margin: var(--sp-6) auto;
}
.qris-amount {
    font-size: 2.2rem;
    color: var(--terracotta);
    font-family: var(--font-heading);
    font-weight: 700;
    margin: var(--sp-2) 0 var(--sp-5) 0;
}
.qris-img-wrap {
    background: #fff;
    padding: 16px;
    border-radius: var(--r-lg);
    display: inline-block;
    border: 1px solid var(--sand);
    box-shadow: var(--shadow-sm);
    margin: var(--sp-3) 0 var(--sp-5) 0;
}
.qris-img-wrap img {
    width: 260px;
    max-width: 100%;
    display: block;
}
.qris-notice {
    background: var(--amber-light);
    color: var(--espresso);
    border: 1px solid var(--amber);
    padding: var(--sp-4);
    border-radius: var(--r-md);
    font-size: var(--fs-sm);
    line-height: 1.5;
    margin-top: var(--sp-5);
}
</style>
</head>
<body>

<div class="container-customer reveal">

    <div class="qris-card">

        <h2 style="margin-top:0;">Scan QRIS Pembayaran</h2>

        <div style="color:var(--taupe); font-size:var(--fs-sm);">
            Order ID: <b>#<?= esc($order['id_order']) ?></b> · Meja: <b><?= esc($order['id_meja']) ?></b>
        </div>

        <div class="qris-amount count-up">
            Rp <?= number_format($order['total'], 0, ',', '.') ?>
        </div>

        <div class="qris-img-wrap">
            <img src="<?= base_url($qris) ?>" alt="QRIS Barcode" onerror="this.src='<?= base_url('uploads/qris.png') ?>'">
        </div>

        <p class="text-sm text-muted">
            Buka aplikasi BCA, GoPay, OVO, Dana, ShopeePay, atau m-Banking Anda, lalu scan QRIS di atas.
        </p>

        <div class="qris-notice">
            ⏳ <b>Menunggu Konfirmasi Kasir...</b><br>
            Halaman ini akan otomatis dialihkan begitu kasir selesai memverifikasi pembayaran Anda.
        </div>

    </div>

</div>

<footer style="text-align:center; padding:var(--sp-8); color:var(--taupe); font-size:var(--fs-sm);">
    © <?= date('Y') ?> <?= esc(setting('nama_warkop') ?? 'Warkop Bahagia') ?>
</footer>

<script src="<?= base_url('assets/theme.js') ?>"></script>
<script>
// Polling status pembayaran
setInterval(function(){
    fetch("<?= base_url('cek-status/'.$order['id_order']) ?>")
    .then(response => response.json())
    .then(data => {
        if(data.status == 'lunas'){
            window.location.href = "<?= base_url('order-success/'.$order['id_order'].'/'.$order['id_meja']) ?>";
        }
    })
    .catch(err => {});
}, 3000);
</script>

</body>
</html>