<?php
$judul = "Tambah Barang Baru";
include 'layout/header.php';
include 'layout/sidebar.php'; 
?>

<div class="container-fluid px-4">
    
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-dark">Tambah Barang</h2>
            <p class="text-muted mb-0">Input data stok barang baru ke database.</p>
        </div>
        <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-5">
        <div class="card-body p-5">
            <?php if(isset($_GET['pesan'])): ?>
    
                <?php if($_GET['pesan'] == 'duplikat_kode'): ?>
                    <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                        <i class="fas fa-exclamation-triangle fa-lg me-3"></i>
                        <div>
                            <strong>Gagal!</strong> Kode Barang tersebut sudah terdaftar.
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>

                <?php elseif($_GET['pesan'] == 'duplikat_nama'): ?>
                    <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
                        <i class="fas fa-box-open fa-lg me-3"></i>
                        <div>
                            <strong>Barang Sudah Ada!</strong> 
                            Nama barang tersebut sudah ada di database. Cek kembali data stok anda.
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                    
                <?php endif; ?>

            <?php endif; ?>
            <form action="proses_tambah.php" ... ></form>
            
            <form action="proses_tambah.php" method="POST">
                <div class="row">
                    
                    <div class="col-md-6 mb-4">
                        <h5 class="fw-bold text-primary mb-3">Informasi Dasar</h5>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold text-uppercase">Kode Barang</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-barcode text-muted"></i></span>
                                <input type="text" name="kode_barang" class="form-control border-start-0" placeholder="Contoh: BRG-001" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold text-uppercase">Nama Barang</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-box text-muted"></i></span>
                                <input type="text" name="nama_barang" class="form-control border-start-0" placeholder="Contoh: Laptop Asus ROG" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <h5 class="fw-bold text-success mb-3">Detail Stok</h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small fw-bold text-uppercase">Stok Awal</label>
                                <input type="number" name="stok" class="form-control" value="0" min="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small fw-bold text-uppercase">Satuan</label>
                                <select name="satuan" class="form-select">
                                    <option value="Pcs">Pcs</option>
                                    <option value="Unit">Unit</option>
                                    <option value="Box">Box</option>
                                    <option value="kg">Kg</option>
                                    <option value="Liter">Liter</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <div class="small">
                                Pastikan kode barang unik. Stok akan bertambah otomatis saat input barang masuk nanti.
                            </div>
                        </div>
                    </div>

                </div>

                <hr class="my-4">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">
                        <i class="fas fa-save me-2"></i> Simpan Data
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>