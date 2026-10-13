<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pengaturan Sistem</title>

    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">

    <style>
        .setting-box{
            max-width:700px;
            margin:auto;
            background:#fff;
            padding:25px;
            border-radius:10px;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
        }

        .form-group{
            margin-bottom:18px;
        }

        .form-group label{
            display:block;
            margin-bottom:8px;
        }

        .form-control{
            width:100%;
            padding:10px;
            border:1px solid #ccc;
            border-radius:6px;
            box-sizing:border-box;
        }

        .logo-preview{
            width:150px;
            height:150px;
            object-fit:cover;
            border-radius:10px;
            border:1px solid #ddd;
            margin-bottom:10px;
        }
    </style>
</head>

<body>

<?= $this->include('layout/navbar_admin') ?>

<div class="container">

    <div class="setting-box">

        <h2>Pengaturan Sistem</h2>

        <?php if(session()->getFlashdata('success')): ?>

            <p style="color:green;">
                <?= session()->getFlashdata('success') ?>
            </p>

        <?php endif; ?>

        <form method="post"
              action="<?= base_url('admin/settings/update') ?>"
              enctype="multipart/form-data">

            <div class="form-group">

                <label>Nama Warkop</label>

                <input
                    type="text"
                    name="nama_warkop"
                    class="form-control"
                    value="<?= esc($settings['nama_warkop'] ?? '') ?>">

            </div>

            <div class="form-group">

                <label>Alamat</label>

                <textarea
                    name="alamat"
                    class="form-control"
                    rows="3"><?= esc($settings['alamat'] ?? '') ?></textarea>

            </div>

            <div class="form-group">

                <label>Kontak</label>

                <input
                    type="text"
                    name="kontak"
                    class="form-control"
                    value="<?= esc($settings['kontak'] ?? '') ?>">

            </div>

                <label>IP / URL Server</label>

                <input
                type="text"
                name="server_url"
                class="form-control"
                value="<?= esc($settings['server_url'] ?? '') ?>"
                placeholder="192.168.1.10:8080">

            <div class="form-group">

                <label>Logo</label>

                <br>

                <img
                    src="<?= base_url($settings['logo'] ?? 'uploads/default-logo.png') ?>"
                    class="logo-preview"
                    alt="Logo">

                <input
                    type="file"
                    name="logo"
                    class="form-control">

            </div>

            <div class="form-group">

    <label>QRIS Warkop</label>

    <br>

                <img
                    src="<?= base_url($settings['qris'] ?? 'uploads/qris.png') ?>"
                    class="logo-preview"
                    alt="QRIS">

    <input type="file"
           name="qris"
           accept="image/*">

</div>

            <button type="submit" class="btn">

                Simpan Setting

            </button>

            <a href="<?= base_url('admin/qr-meja') ?>"
class="btn">

Generate QR Meja

</a>

        </form>

    </div>

</div>

</body>
</html>