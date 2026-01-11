<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | SIM Apotek Bunda</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="<?= base_url('vendors/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('vendors/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f9fafb, #eef2f7);
            height: 100vh;
            font-family: "Segoe UI", sans-serif;
        }
        .register-wrapper {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-card {
            background: #fff;
            width: 100%;
            max-width: 450px;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,.08);
        }
        .btn-register {
            background: #2563eb;
            border: none;
            width: 100%;
            height: 42px;
            font-weight: 600;
            border-radius: 8px;
        }
    </style>
</head>

<body>

<div class="register-wrapper">
    <div class="register-card">

        <h3 class="text-center">Registrasi Akun</h3>
        <p class="text-center text-muted">SIM Apotek Bunda</p>

        <?php if ($this->session->flashdata('register_error')): ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('register_error'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('register_success')): ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('register_success'); ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('example/register_user'); ?>" method="POST">

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <!-- LEVEL -->
    <div class="form-group">
    <label>Daftar Sebagai</label>
    <select name="level_id" class="form-control" required>
        <option value="">-- Pilih Level --</option>
        <option value="pemilik">Pemilik</option>
        <option value="kasir">Kasir</option>
    </select>
</div>


            <div class="form-group">
    <label>Password</label>
    <div class="input-group">
        <input type="password" name="password" id="password" class="form-control" required>
        <span class="input-group-addon" style="cursor:pointer;" onclick="togglePassword('password', this)">
            <i class="fa fa-eye"></i>
        </span>
    </div>
    <small class="text-muted">
        Minimal 8 karakter, mengandung huruf, angka, dan karakter khusus
        (contoh: <b>Apotek@123</b>)
    </small>
</div>

<div class="form-group">
    <label>Konfirmasi Password</label>
    <div class="input-group">
        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
        <span class="input-group-addon" style="cursor:pointer;" onclick="togglePassword('confirm_password', this)">
            <i class="fa fa-eye"></i>
        </span>
    </div>
</div>

            <button type="submit" class="btn btn-register">
                <i class="fa fa-user-plus"></i> Daftar
            </button>

            <p class="text-center" style="margin-top:15px;">
                Sudah punya akun?
                <a href="<?= base_url('example/login'); ?>">Login</a>
            </p>

        </form>
    </div>
</div>

<script>
function togglePassword(id, el) {
    const input = document.getElementById(id);
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
