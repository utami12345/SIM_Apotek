<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | SIM Apotek Bunda</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & FontAwesome -->
    <link href="<?= base_url('vendors/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('vendors/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f9fafb, #eef2f7);
            height: 100vh;
            font-family: "Segoe UI", sans-serif;
        }

        .login-wrapper {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #ffffff;
            width: 100%;
            max-width: 420px;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }

        .login-title {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-title h3 {
            font-weight: 600;
            color: #111827;
            margin-bottom: 5px;
        }

        .login-title p {
            color: #6b7280;
            font-size: 13px;
        }

        .alert {
            font-size: 13px;
        }

        .form-group label {
            font-weight: 500;
            color: #374151;
            font-size: 13px;
        }

        .input-group-addon {
            background: #f3f4f6;
            border-right: none;
        }

        .form-control {
            border-left: none;
            height: 42px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #2563eb;
        }

        .btn-login {
            background: #2563eb;
            border: none;
            width: 100%;
            height: 42px;
            font-weight: 600;
            border-radius: 8px;
        }

        .btn-login:hover {
            background: #1e40af;
        }

        .footer-text {
            text-align: center;
            margin-top: 15px;
            font-size: 12px;
            color: #9ca3af;
        }

        .toggle-password {
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="login-wrapper">
    <div class="login-card">

        <div class="login-title">
            <h3>SIM Apotek Bunda</h3>
            <p>Silakan Login Untuk Mengakses Sistem</p>
        </div>

        <!-- NOTIFIKASI ERROR -->
        <?php if ($this->session->flashdata('login_error')) : ?>
    <div class="alert alert-danger text-center">
        <i class="fa fa-warning"></i>
        <?= $this->session->flashdata('login_error'); ?>
    </div>
    <?php $this->session->unset_userdata('login_error'); ?>
<?php endif; ?>


        <form id="formLogin" action="<?= base_url('example/login_masuk'); ?>" method="POST">

            <!-- USERNAME -->
            <div class="form-group">
                <label>Username</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </span>
                    <input type="text" name="username" class="form-control"
                           placeholder="Masukkan username" required>
                </div>
            </div>

            <!-- PASSWORD -->
            <div class="form-group">
    <label>Password</label>
    <div class="input-group">
        <span class="input-group-addon">
            <i class="fa fa-lock"></i>
        </span>

        <input type="password"
               name="password"
               id="password"
               class="form-control"
               placeholder="Minimal 8 karakter"
               required>

        <span class="input-group-addon toggle-password"
              onclick="togglePassword(this)">
            <i class="fa fa-eye"></i>
        </span>
    </div>

    <small class="text-muted">
        Password harus mengandung huruf, angka, dan karakter khusus
        (contoh: <b>Apotek@123</b>)
    </small>
</div>


            <button type="submit" class="btn btn-login">
                <i class="fa fa-sign-in"></i> Login
            </button>

            <div class="footer-text">
                Belum punya akun?
                <a href="<?= base_url('example/register'); ?>"
                   style="color:#2563eb; font-weight:600;">
                    Daftar di sini
                </a>
            </div>

        </form>

        <div class="footer-text">
            © <?= date('Y'); ?> SIM Apotek Bunda
        </div>

    </div>
</div>

<!-- JS -->
<script src="<?= base_url('vendors/jquery/dist/jquery.min.js') ?>"></script>

<script>
    // VALIDASI PASSWORD MINIMAL 8 KARAKTER
    document.getElementById('formLogin').addEventListener('submit', function (e) {
        let password = document.getElementById('password').value;

        if (password.length < 8) {
            e.preventDefault();
            alert('Password harus minimal 8 karakter');
        }
    });

    // TOGGLE SHOW / HIDE PASSWORD
    function togglePassword(el) {
        const input = document.getElementById('password');
        const icon = el.querySelector('i');

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>

</body>
</html>
