<?php
$judul = "Edit Data Barang";
include 'layout/header.php';
include 'layout/sidebar.php'; // PENTING: Pakai Sidebar
include 'config/database.php';

// Ambil ID & Validasi
if(!isset($_GET['id'])) { header("location: index.php"); exit; }
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM barang WHERE id = '$id'");
$data  = mysqli_fetch_array($query);

if(mysqli_num_rows($query) < 1) die("Data tidak ditemukan...");
?>

<div class="container-fluid px-4">
    
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-dark">Edit Barang</h2>
            <p class="text-muted mb-0">Perbarui informasi stok barang.</p>
        </div>
        <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i> Batal
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-5">
        <div class="card-body p-5">
            
            <form action="proses_edit.php" method="POST">
                <input type="hidden" name="id" value="<?= $data['id']; ?>">

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h5 class="fw-bold text-warning mb-3">Informasi Dasar</h5>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold text-uppercase">Kode Barang</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 bg-light" value="<?= $data['kode_barang']; ?>" readonly>
                            </div>
                            <small class="text-muted fst-italic">Kode barang tidak dapat diubah.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold text-uppercase">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" value="<?= $data['nama_barang']; ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <h5 class="fw-bold text-success mb-3">Detail Stok</h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small fw-bold text-uppercase">Stok Saat Ini</label>
                                <input type="number" name="stok" class="form-control fw-bold" value="<?= $data['stok']; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small fw-bold text-uppercase">Satuan</label>
                                <select name="satuan" class="form-select">
                                    <option value="Pcs" <?= ($data['satuan'] == 'Pcs') ? 'selected' : ''; ?>>Pcs</option>
                                    <option value="Unit" <?= ($data['satuan'] == 'Unit') ? 'selected' : ''; ?>>Unit</option>
                                    <option value="Box" <?= ($data['satuan'] == 'Box') ? 'selected' : ''; ?>>Box</option>
                                    <option value="kg" <?= ($data['satuan'] == 'kg') ? 'selected' : ''; ?>>Kg</option>
                                    <option value="Liter" <?= ($data['satuan'] == 'Liter') ? 'selected' : ''; ?>>Liter</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">
                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-light rounded-pill px-4">Reset</button>
                    <button type="submit" class="btn btn-warning text-white btn-lg rounded-pill px-5 shadow-sm">
                        <i class="fas fa-check-circle me-2"></i> Update Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>