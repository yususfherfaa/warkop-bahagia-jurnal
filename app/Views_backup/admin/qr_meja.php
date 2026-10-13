<?= $this->include('layout/navbar_admin') ?>

<style>

    body{
    font-family: Arial, sans-serif;
    background:#f5f7fb;
    margin:0;
}

.container{
    max-width:1200px;
    margin:30px auto;
}

.title{
    text-align:center;
    color:#007bff;
    font-size:32px;
    font-weight:normal;
    margin-bottom:30px;
}

.qr-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(280px,1fr));
    gap:25px;
}

.qr-card{
    background:white;
    border-radius:15px;
    padding:20px;
    text-align:center;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
    transition:.3s;
}

.qr-card:hover{
    transform:translateY(-5px);
}

.meja-title{
    font-size:24px;
    color:#007bff;
    margin-bottom:15px;
    font-weight:normal;
}

.qr-image{
    margin:15px 0;
}

.qr-image img{
    width:180px;
    height:180px;
}

.link-box{
    background:#f5f7fb;
    padding:10px;
    border-radius:8px;
    font-size:12px;
    word-break:break-all;
    margin-bottom:15px;
}

.btn{
    display:inline-block;
    padding:10px 15px;
    border-radius:8px;
    text-decoration:none;
    color:white;
    margin:3px;
}

.btn-view{
    background:#007bff;
}

.btn-download{
    background:#28a745;
}

.btn:hover{
    opacity:.9;
}

</style>

<div class="container">

    <h2 class="title">
        Generate QR Code Meja
    </h2>

    <div class="qr-grid">

        <?php foreach($meja as $m): ?>

            <?php
            $url = 'http://' . $serverUrl . '/order/' . $m['id_meja'];

            $qrUrl =
            'https://api.qrserver.com/v1/create-qr-code/?size=500x500&data='
            . urlencode($url);
            ?>

            <div class="qr-card">

                <div class="meja-title">
                    <?= $m['id_meja'] ?>
                </div>

                <div class="qr-image">
                    <img src="<?= $qrUrl ?>">
                </div>

                <div class="link-box">
                    <?= $url ?>
                </div>

                <a
                    href="<?= $url ?>"
                    target="_blank"
                    class="btn btn-view">

                    Test Link

                </a>

                <a
                    href="<?= $qrUrl ?>"
                    download="<?= $m['id_meja'] ?>.png"
                    class="btn btn-download">

                    Download

                </a>

            </div>

        <?php endforeach; ?>

    </div>

</div>