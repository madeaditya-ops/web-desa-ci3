<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Desa Blahbatuh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4; /* Warna latar belakang abu-abu muda */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Kontainer Utama Login */
        .login-container {
            background-color: #ffffff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            border: 1px solid #e0e0e0;
        }

        /* Styling Logo */
        .login-logo img {
            width: 80px; /* Sesuaikan ukuran logo */
            margin-bottom: 10px;
        }

        .login-title h2 {
            margin: 0;
            font-size: 1.2rem;
            color: #d9534f; /* Warna merah seperti di gambar */
            font-weight: 600;
        }

        .login-title p {
            margin: 5px 0 25px 0;
            font-size: 0.9rem;
            color: #6c757d; /* Warna abu-abu untuk sub-judul */
        }

        /* Styling Form Group */
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        /* Styling Input Fields */
        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: none; /* Hilangkan border default */
            background-color: #e9e9e9; /* Warna latar input */
            border-radius: 8px;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        .form-input::placeholder {
            color: #888;
        }

        /* Styling Button Group */
        .button-group {
            display: flex;
            gap: 10px; /* Memberi jarak antar tombol */
            margin-top: 10px;
        }

        .btn {
            flex: 1; /* Membuat kedua tombol memiliki lebar yang sama */
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-2px); /* Efek sedikit terangkat saat hover */
        }

        .btn-login {
            background-color: #2c3e50; /* Warna biru tua */
        }

        .btn-login:hover {
            background-color: #34495e;
        }

        .btn-kembali {
            background-color: #c0392b; /* Warna merah */
        }

        .btn-kembali:hover {
            background-color: #e74c3c;
        }

    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-logo">
            <img src="<?= base_url('assets/image/logo_desa_blahbatuh.png'); ?>" alt="Logo Desa">
        </div>

        <div class="login-title">
            <h2>DESA BLAHBATUH</h2>
            <p>Kecamatan Blahbatuh~Gianyar</p>
        </div>

        <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>
        
        <form method="post" action="<?= site_url('auth/login'); ?>">
            <div class="form-group">
                <input type="text" class="form-input" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-input" name="password" placeholder="Password" required>
            </div>
            <div class="button-group">
                <button type="submit" class="btn btn-login">Login</button>
                <a href="<?= base_url('landing'); ?>" class="btn btn-kembali" style="text-decoration: none; text-align: center;">Kembali</a>
            </div>
        </form>
    </div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
  </html>