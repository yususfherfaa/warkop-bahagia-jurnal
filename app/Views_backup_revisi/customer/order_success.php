<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">

    <title>
        Pesanan Berhasil
    </title>

    <link rel="stylesheet"
          href="<?= base_url('assets/style.css') ?>">

    <style>

        body{
            font-family:Arial;
            background:#f7faff;

            display:flex;
            justify-content:center;
            align-items:center;

            height:100vh;
        }

        .box{

            background:#fff;

            padding:30px;

            border-radius:10px;

            box-shadow:
                0 2px 8px rgba(0,0,0,0.1);

            text-align:center;

            max-width:400px;
        }

        .success-icon{

            font-size:60px;

            color:#28a745;
        }

        .btn{

            display:inline-block;

            background:#007bff;

            color:#fff;

            text-decoration:none;

            padding:10px 20px;

            border-radius:6px;

            margin-top:15px;
        }

    </style>
</head>

<body>

<div class="box">

    <div class="success-icon">
        ✅
    </div>

    <h2>
        Pesanan Berhasil!
    </h2>

    <p>

        Pesanan untuk

        <b>
            <?= esc($order['id_meja']) ?>
        </b>

        berhasil dikirim.

    </p>

    <?php if (($order['metode_pembayaran'] ?? 'cash') == 'cash'): ?>

<p>
    Silakan lakukan pembayaran di kasir.
</p>

<?php else: ?>

<p>
    Pembayaran QRIS berhasil diverifikasi.
</p>

<?php endif; ?>

    <p>

        <small>

            Order ID:

            <b>
                #<?= esc($order['id_order']) ?>
            </b>

            <br>

            Status:

            <?= ucfirst(
                str_replace(
                    '_',
                    ' ',
                    $order['status']
                )
            ) ?>

        </small>

    </p>

    <a href="<?= base_url('/order/'.$id_meja) ?>"
       class="btn">

        Kembali ke Menu

    </a>

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