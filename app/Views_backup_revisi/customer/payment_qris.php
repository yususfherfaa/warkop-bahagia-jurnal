<!doctype html>
<html lang="id">

<head>

<meta charset="utf-8">

<title>Pembayaran QRIS</title>

<style>

body{
    margin:0;
    font-family:Arial, sans-serif;
    background:#f5f7fb;
}

.container{
    max-width:600px;
    margin:50px auto;
}

.card{
    background:white;
    padding:30px;
    border-radius:15px;
    text-align:center;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

h2{
    color:#007bff;
    margin-bottom:20px;
}

.order{
    font-size:18px;
    margin-bottom:10px;
}

.total{
    font-size:32px;
    color:#28a745;
    font-weight:bold;
    margin-bottom:20px;
}

.qris{
    margin:20px 0;
}

.qris img{
    width:300px;
    max-width:100%;
}

.info{
    color:#dc3545;
    font-size:16px;
    margin-top:20px;
}

</style>

</head>

<body>

<div class="container">

    <div class="card">

        <h2>Scan QRIS Untuk Pembayaran</h2>

        <div class="order">
            Order ID :
            <b><?= esc($order['id_order']) ?></b>
        </div>

        <div class="order">
            Meja :
            <b><?= esc($order['id_meja']) ?></b>
        </div>

        <div class="order">
            Pelanggan :
            <b><?= esc($order['nama_pelanggan']) ?></b>
        </div>

        <div class="total">
            Rp <?= number_format($order['total'],0,',','.') ?>
        </div>

        <div class="qris">

            <img src="<?= base_url('uploads/qris.png') ?>"
                 alt="QRIS">

        </div>

        <div class="info">
            Setelah melakukan pembayaran,
            silakan tunggu verifikasi dari kasir.
        </div>

    </div>

</div>

</body>
</html>

<script>

setInterval(function(){

    fetch("<?= base_url('cek-status/'.$order['id_order']) ?>")
    .then(response => response.json())
    .then(data => {

        if(data.status == 'lunas'){

            window.location.href =
            "<?= base_url('order-success/'.$order['id_order'].'/'.$id_meja) ?>";

        }

    });

}, 3000);

</script>