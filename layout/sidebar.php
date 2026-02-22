<nav class="sidebar">
    <div class="brand">
        <i class="fas fa-boxes me-2"></i> INVENTARIS
    </div>
    
    <div class="nav flex-column">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex px-3 border-bottom border-secondary">
            <div class="image text-white">
                <i class="fas fa-user-circle fa-2x"></i>
            </div>
            <div class="info ms-3">
                <a href="<?= $base_url ?>pages/profile.php" class="d-block text-white text-decoration-none fw-bold">
                    <?= isset($_SESSION['nama']) ? $_SESSION['nama'] : 'User'; ?>
                </a>
                <small class="text-white-50 text-uppercase" style="font-size: 0.7rem;">
                    <?= isset($_SESSION['role']) ? $_SESSION['role'] : 'Admin'; ?>
                </small>
            </div>
        </div>
        <a href="<?= $base_url ?>index.php" class="nav-link">
            <i class="fas fa-home me-2" style="width: 20px;"></i> Dashboard
        </a>
        
        <div class="text-uppercase text-white small fw-bold px-4 mt-3 mb-1">Transaksi</div>
        
        <a href="<?= $base_url ?>pages/barang_masuk.php" class="nav-link">
            <i class="fas fa-plus-circle me-2" style="width: 20px;"></i> Barang Masuk
        </a>
        <a href="<?= $base_url ?>pages/barang_keluar.php" class="nav-link">
            <i class="fas fa-minus-circle me-2" style="width: 20px;"></i> Barang Keluar
        </a>

        <div class="text-uppercase text-white small fw-bold px-4 mt-3 mb-1">Laporan & Riwayat</div>
        
        <a href="<?= $base_url ?>pages/riwayat_masuk.php" class="nav-link">
            <i class="fas fa-file-import me-2" style="width: 20px;"></i> Riwayat Masuk
        </a>

        <a href="<?= $base_url ?>pages/riwayat_keluar.php" class="nav-link">
            <i class="fas fa-file-export me-2" style="width: 20px;"></i> Riwayat Keluar
        </a>
        
        <div class="text-uppercase text-white small fw-bold px-4 mt-3 mb-1">Pengaturan</div>

        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                
            <a href="<?= $base_url ?>pages/users.php" class="nav-link">
                <i class="fas fa-users-cog me-2" style="width: 20px;"></i> Kelola User
            </a>

        <?php endif; ?>

        <a href="<?= $base_url ?>pages/profile.php" class="nav-link">
            <i class="fas fa-user-cog me-2" style="width: 20px;"></i> Profil & Password
        </a>
                
        <a href="<?= $base_url ?>logout.php" class="nav-link text-danger"> <i class="fas fa-sign-out-alt me-2" style="width: 20px;"></i> Logout
        </a>
    </div>
</nav>

<div class="main-content w-100">