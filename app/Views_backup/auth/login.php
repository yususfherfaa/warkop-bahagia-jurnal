<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>

    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">

    <style>
        .login-input{
            width:100%;
            padding:10px;
            border:1px solid #ccc;
            border-radius:6px;
            box-sizing:border-box;
        }

        .logo{
            width:120px;
            height:120px;
            object-fit:cover;
            border-radius:10px;
        }
    </style>
</head>

<body>

<div class="container center">

    <h2 class="logo-title">
    <?= esc($nama_warkop) ?>
</h2>

    <div style="display:flex; justify-content:center; margin-bottom:15px;">

        <img
            src="<?= base_url($logo) ?>"
            class="logo"
            alt="Logo Warkop">

    </div>

    <div class="card"
         style="max-width:420px;margin:12px auto;padding:18px">

        <?php if (!empty($msg)): ?>

            <p style="color:red">

                <?= esc($msg) ?>

            </p>

        <?php endif; ?>

        <form method="post"
              action="<?= base_url('/login/process') ?>">

            <div class="form-row" style="margin-bottom:12px;">

                <input
                    type="text"
                    name="username"
                    class="login-input"
                    placeholder="Username"
                    required>

            </div>

            <div class="form-row" style="margin-bottom:12px;">

                <input
                    type="password"
                    name="password"
                    class="login-input"
                    placeholder="Password"
                    required>

            </div>

            <div class="form-row">

                <button class="btn" type="submit" style="width:100%;">

                    Login

                </button>

            </div>

        </form>

        <p class="small center">

            Login menggunakan akun kasir/admin

        </p>

    </div>

</div>

<footer>

© <?= date('Y') ?> <?= esc($nama_warkop) ?>

</footer>

</body>
</html>