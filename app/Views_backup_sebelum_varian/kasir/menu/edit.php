<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Menu — <?= esc(setting('nama_warkop') ?? 'Warkop Bahagia') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/theme.css') ?>">
    <style>
        .form-edit-card {
            background: var(--ivory);
            padding: var(--sp-8);
            border-radius: var(--r-xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--sand);
            max-width: 560px;
            margin: var(--sp-6) auto;
        }
        .form-group {
            margin-bottom: var(--sp-5);
        }
        .form-group label {
            display: block;
            margin-bottom: var(--sp-2);
            font-weight: 600;
            color: var(--espresso);
            font-size: var(--fs-sm);
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid var(--beige);
            background: var(--ivory);
            border-radius: var(--r-input);
            font-family: var(--font-body);
            font-size: var(--fs-body);
            color: var(--espresso);
            box-sizing: border-box;
            transition: all var(--dur-fast) var(--ease);
        }
        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--terracotta);
            outline: none;
            box-shadow: 0 0 0 3px rgba(196, 127, 94, 0.18);
        }
        .img-preview-box {
            display: flex;
            align-items: center;
            gap: var(--sp-4);
            margin-bottom: var(--sp-3);
        }
        .img-preview-box img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: var(--r-md);
            border: 1.5px solid var(--beige);
            background: var(--cream);
        }
        .btn-update-menu {
            width: 100%;
            padding: 12px;
            background: var(--grad-btn);
            color: white;
            border: none;
            border-radius: var(--r-btn);
            cursor: pointer;
            font-weight: 700;
            font-family: var(--font-body);
            box-shadow: var(--shadow-btn);
            transition: all var(--dur-fast) var(--ease);
        }
        .btn-update-menu:hover {
            box-shadow: var(--shadow-btn-hover);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<?= $this->include('layout/navbar_kasir') ?>

<div class="container reveal">

    <div class="form-edit-card">

        <div style="margin-bottom:var(--sp-6);">
            <a href="<?= base_url('/kasir/menu') ?>" style="font-size:var(--fs-xs); color:var(--taupe); text-decoration:none;">
                ← Kembali ke Manajemen Menu
            </a>
            <h2 style="text-align:left; margin:8px 0 4px 0;">Edit Data Menu</h2>
            <p class="text-muted" style="font-size:var(--fs-sm); margin:0;">Perbarui detail harga, stok, atau foto produk.</p>
        </div>

        <form method="post"
              action="<?= base_url('/kasir/menu/update/'.$product['id_produk']) ?>"
              enctype="multipart/form-data">

            <div class="form-group">
                <label>Nama Menu</label>
                <input type="text" name="nama"
                       value="<?= esc($product['nama']) ?>"
                       placeholder="Nama Produk"
                       required>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Makanan Berat" <?= $product['kategori'] == 'Makanan Berat' ? 'selected' : '' ?>>Makanan Berat</option>
                    <option value="Cemilan" <?= $product['kategori'] == 'Cemilan' ? 'selected' : '' ?>>Cemilan</option>
                    <option value="Minuman Kopi" <?= $product['kategori'] == 'Minuman Kopi' ? 'selected' : '' ?>>Minuman Kopi</option>
                    <option value="Minuman Non Kopi" <?= $product['kategori'] == 'Minuman Non Kopi' ? 'selected' : '' ?>>Minuman Non Kopi</option>
                </select>
            </div>

            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="harga"
                       value="<?= esc($product['harga']) ?>"
                       placeholder="Harga"
                       required>
            </div>

            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok"
                       value="<?= esc($product['stok']) ?>"
                       placeholder="Stok"
                       required>
            </div>

            <div class="form-group">
                <label>Foto Produk Saat Ini</label>
                <div class="img-preview-box">
                    <img src="<?= base_url('uploads/'.$product['gambar']) ?>"
                         id="menuImgPreview"
                         alt="<?= esc($product['nama']) ?>"
                         onerror="this.src='<?= base_url('assets/noimage.png') ?>'">
                    <div>
                        <input type="file" name="gambar" accept="image/*" onchange="previewMenuImg(this)">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto.</small>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-update-menu">
                💾 Perbarui Menu
            </button>

        </form>

    </div>

</div>

<footer style="text-align:center; padding:var(--sp-8); color:var(--taupe); font-size:var(--fs-sm);">
    © <?= date('Y') ?> <?= esc(setting('nama_warkop') ?? 'Warkop Bahagia') ?>
</footer>

<script src="<?= base_url('assets/theme.js') ?>"></script>
<script>
function previewMenuImg(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('menuImgPreview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</body>
</html>