<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Inventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #2c3e50; /* Warna Background Gelap */
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-login {
            width: 100%;
            max-width: 400px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .btn-primary {
            background-color: #2c3e50;
            border: none;
        }
        .btn-primary:hover {
            background-color: #34495e;
        }
    </style>
</head>
<body>

    <div class="card card-login bg-white p-5">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-dark">INVENTARIS</h3>
            <p class="text-muted">Silakan login untuk mengelola gudang</p>
        </div>

        <?php 
        if(isset($_GET['pesan'])){
            if($_GET['pesan'] == "gagal"){
                echo "<div class='alert alert-danger'>Login gagal! Username atau Password salah.</div>";
            }
            else if($_GET['pesan'] == "logout"){
                echo "<div class='alert alert-success'>Anda telah berhasil logout.</div>";
            }
            else if($_GET['pesan'] == "belum_login"){
                echo "<div class='alert alert-warning'>Anda harus login Terlebih Dahulu.</div>";
            }
            // TAMBAHKAN INI:
            else if($_GET['pesan'] == "timeout"){
                echo "<div class='alert alert-warning'>
                        <i class='fas fa-clock me-1'></i> Sesi habis! Silahkan login lagi.
                    </div>";
            }
        }
        ?>

        <form action="proses_login.php" method="POST">
            <div class="mb-3">
                <label class="form-label small fw-bold">USERNAME</label>
                <input type="text" name="username" class="form-control" placeholder="Masukan username" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-bold">PASSWORD</label>
                <input type="password" name="password" class="form-control" placeholder="Masukan password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill">MASUK</button>
        </form>
        
        <div class="text-center mt-4">
            <small class="text-muted">&copy; 2026 Sistem Inventaris</small>
        </div>
    </div>

</body>
</html>