<?php
include '../config/database.php';
$judul = "Profil Saya";
include '../layout/header.php';
include '../layout/sidebar.php';

// Ambil data user yang sedang login
$username = $_SESSION['username'];
$query_user = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$u = mysqli_fetch_assoc($query_user);

// --- LOGIKA GANTI PASSWORD ---
if(isset($_POST['ganti_password'])){
    $pass_lama = $_POST['pass_lama'];
    $pass_baru = $_POST['pass_baru'];
    $konfirmasi = $_POST['konfirmasi'];

    // 1. Cek Password Lama Benar Gak?
    // (Sesuaikan logika ini dengan sistem login kamu, apakah MD5 atau Plain Text)
    // Karena tadi kita pakai PLAIN TEXT, maka:
    if($pass_lama == $u['password']){
        
        // 2. Cek Password Baru & Konfirmasi Sama Gak?
        if($pass_baru == $konfirmasi){
            
            // 3. Lakukan Update
            mysqli_query($conn, "UPDATE users SET password='$pass_baru' WHERE id='$u[id]'");
            echo "<script>alert('SUKSES! Password berhasil diubah.'); window.location='profile.php';</script>";
            
        } else {
            echo "<script>alert('GAGAL! Konfirmasi password tidak cocok.');</script>";
        }

    } else {
        echo "<script>alert('GAGAL! Password Lama Salah.');</script>";
    }
}
?>

<div class="container-fluid px-4">
    <h2 class="mt-4 fw-bold text-dark">Profil Pengguna</h2>
    <p class="text-muted">Kelola akun Anda disini.</p>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm text-center py-5">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-user-circle fa-5x text-secondary"></i>
                    </div>
                    
                    <h4 class="fw-bold"><?= ucfirst($u['username']); ?></h4>
                    
                    <span class="badge bg-primary text-uppercase"><?= $u['role']; ?></span>
                    
                    <p class="text-muted mt-3 small">
                        Status Akun: <b>Aktif</b>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-dark"><i class="fas fa-key me-2"></i> Ganti Password</h6>
                </div>
                <div class="card-body p-4">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Password Lama</label>
                            <input type="password" name="pass_lama" class="form-control" required placeholder="Masukan password saat ini...">
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Password Baru</label>
                            <input type="password" name="pass_baru" class="form-control" required placeholder="Masukan password baru...">
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted small fw-bold">Konfirmasi Password Baru</label>
                            <input type="password" name="konfirmasi" class="form-control" required placeholder="Ulangi password baru...">
                        </div>
                        <button type="submit" name="ganti_password" class="btn btn-primary px-4">
                            Simpan Password Baru
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>