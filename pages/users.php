<?php
include '../config/database.php';
$judul = "Manajemen User";
include '../layout/header.php';
include '../layout/sidebar.php';

if($_SESSION['role'] != 'admin'){
    echo "<script>alert('Akses Ditolak!'); window.location='../index.php';</script>";
    exit;
}
?>

<div class="container-fluid px-4">
    
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-dark">Kelola User</h2>
            <p class="text-muted mb-0">Tambah atau hapus akun akses sistem.</p>
        </div>
        <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
            <i class="fas fa-user-plus me-2"></i> Tambah User
        </button>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">No</th>
                            <th>Username</th>
                            <th>Role / Jabatan</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM users ORDER BY role ASC, username ASC");
                        $no = 1;
                        while($u = mysqli_fetch_array($query)):
                        ?>
                        <tr>
                            <td class="ps-4"><?= $no++; ?></td>
                            <td class="fw-bold"><?= $u['username']; ?></td>
                            <td>
                                <?php if($u['role'] == 'admin'): ?>
                                    <span class="badge bg-primary">ADMIN</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">GUDANG</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-4">
    
                                <?php if($u['username'] != $_SESSION['username']): ?>
                                    
                                    <button type="button" class="btn btn-sm btn-outline-warning me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalReset<?= $u['id']; ?>" 
                                            title="Reset Password">
                                        <i class="fas fa-key"></i>
                                    </button>

                                    <a href="proses_user.php?aksi=hapus&id=<?= $u['id']; ?>" 
                                    class="btn btn-sm btn-outline-danger" 
                                    onclick="return confirm('Yakin hapus user ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>

                                    <div class="modal fade text-start" id="modalReset<?= $u['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title fw-bold text-dark">Reset Password: <?= $u['username']; ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="proses_user.php" method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="aksi" value="reset">
                                                        <input type="hidden" name="id" value="<?= $u['id']; ?>">

                                                        <div class="alert alert-warning small mb-3 text-dark">
                                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                                            Password lama akan dihapus. User harus login dengan password baru ini.
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Password Baru</label>
                                                            <input type="text" name="password_baru" class="form-control" required placeholder="Cth: baru123">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-warning fw-bold text-dark">Simpan Password</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                <?php else: ?>
                                    <span class="badge bg-light text-muted border px-3 py-2">
                                        <i class="fas fa-user-check me-1"></i> Akun Anda
                                    </span>
                                <?php endif; ?>

                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahUser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="proses_user.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="aksi" value="tambah">

                    <div class="mb-3">
                        <label class="form-label">Username (Login)</label>
                        <input type="text" name="username" class="form-control" required placeholder="Cth: staff_gudang">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="text" name="password" class="form-control" required placeholder="Masukan password...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role / Hak Akses</label>
                        <select name="role" class="form-select">
                            <option value="gudang">GUDANG (Hanya Input & Cetak)</option>
                            <option value="admin">ADMIN (Full Akses)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>