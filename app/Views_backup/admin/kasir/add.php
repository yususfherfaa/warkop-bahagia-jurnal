<!doctype html>
<html lang="id">

<head>

<meta charset="utf-8">

<title>Tambah Kasir</title>

<link rel="stylesheet"
      href="<?= base_url('assets/style.css') ?>">

<style>

.form-box {
    max-width:500px;
    margin:auto;
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 2px 8px rgba(0,0,0,0.08);
}

.form-box h2 {
    margin-bottom:20px;
    color:#007bff;
    text-align:center;
    font-weight:normal;
}

.form-group {
    margin-bottom:18px;
}

.form-group label {
    display:block;
    margin-bottom:8px;
}

.form-group input {
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:6px;
    outline:none;
    font-size:15px;
}

.form-group input:focus {
    border-color:#007bff;
    box-shadow:0 0 5px rgba(0,123,255,0.2);
}

.btn-submit {
    width:100%;
    padding:12px;
    border:none;
    background:#007bff;
    color:white;
    border-radius:6px;
    cursor:pointer;
    font-size:15px;
    transition:0.2s;
}

.btn-submit:hover {
    background:#0069d9;
}

</style>

</head>

<body>

<?= $this->include('layout/navbar_admin') ?>

<div class="container">

<div class="form-box">

<h2>Tambah Kasir</h2>

<form method="post"
      action="<?= base_url('admin/kasir/save') ?>">

    <div class="form-group">

        <label>Nama Kasir</label>

        <input type="text"
               name="nama"
               placeholder="Masukkan nama kasir"
               required>

    </div>

    <div class="form-group">

        <label>Username</label>

        <input type="text"
               name="username"
               placeholder="Masukkan username"
               required>

    </div>

    <div class="form-group">

        <label>Password</label>

        <input type="password"
               name="password"
               placeholder="Masukkan password"
               required>

    </div>

    <button type="submit"
            class="btn-submit">
        Simpan Kasir
    </button>

</form>

</div>

</div>

</body>
</html>