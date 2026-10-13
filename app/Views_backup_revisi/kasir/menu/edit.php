<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Edit Produk</title>

    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">

    <style>
        body{
            font-family:Arial;
            background:#f4f6f9;
            margin:0;
        }

        .container{
            padding:20px;
        }

        .form-box{
            background:white;
            padding:20px;
            border-radius:10px;
            box-shadow:0 2px 8px rgba(0,0,0,0.08);
            max-width:500px;
            justify-content:center;
             max-width:500px;
             margin:0 auto;

        }

        input{
            width:100%;
            padding:10px;
            margin:8px 0;
            border:1px solid #ddd;
            border-radius:6px;
        }

        select{
            width:100%;
            padding:10px;
            margin:8px 0;
            border:1px solid #ddd;
            border-radius:6px;
        }

        button{
            background:#007bff;
            color:white;
            padding:10px 15px;
            border:none;
            border-radius:6px;
            cursor:pointer;
        }
    </style>
</head>

<body>

<?= $this->include('layout/navbar_kasir') ?>

<div class="container">

    <h2>Edit Produk</h2>

    <div class="form-box">

        <form method="post"
              action="<?= base_url('/kasir/menu/update/'.$product['id_produk']) ?>"
              enctype="multipart/form-data">

            <input type="text" name="nama"
                   value="<?= esc($product['nama']) ?>"
                   placeholder="Nama Produk">

            <select name="kategori" required>
    <option value="">Pilih Kategori</option>
    <option value="Makanan Berat">Makanan Berat</option>
    <option value="Cemilan">Cemilan</option>
    <option value="Minuman Kopi">Minuman Kopi</option>
    <option value="Minuman Non Kopi">Minuman Non Kopi</option>
</select>

            <input type="number" name="harga"
                   value="<?= esc($product['harga']) ?>"
                   placeholder="Harga">

            <input type="number" name="stok"
                   value="<?= esc($product['stok']) ?>"
                   placeholder="Stok">

            <input type="file" name="gambar">

            <button type="submit">Update</button>

        </form>

    </div>

</div>

</body>
</html>