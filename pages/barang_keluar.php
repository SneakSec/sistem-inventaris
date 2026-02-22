<?php
include '../config/database.php';
$judul = "Transaksi Barang Keluar";
include '../layout/header.php';
include '../layout/sidebar.php';
?>

<div class="container-fluid px-4">
    
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-dark">Barang Keluar</h2>
            <p class="text-muted mb-0">Catat pengambilan barang dari gudang.</p>
        </div>
    </div>

    <div class="row">
        
        <div class="col-md-5 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-danger"><i class="fas fa-minus-circle me-2"></i> Input Barang Keluar</h6>
                </div>
                <div class="card-body">
                    <form action="proses_keluar.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase">Tanggal Keluar</label>
                            <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase">Pilih Barang</label>
                            <select name="barang_id" class="form-select" required>
                                <option value="">-- Pilih Barang --</option>
                                <?php
                                $ambil = mysqli_query($conn, "SELECT * FROM barang ORDER BY nama_barang ASC");
                                while($b = mysqli_fetch_array($ambil)){
                                    // Tampilkan sisa stok agar user tahu batas maksimalnya
                                ?>
                                    <option value="<?= $b['id']; ?>">
                                        <?= $b['kode_barang'] . " - " . $b['nama_barang'] . " (Sisa Stok: " . $b['stok'] . ")"; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase">Jumlah Keluar</label>
                            <div class="input-group">
                                <input type="number" name="jumlah" class="form-control" min="1" required placeholder="0">
                                <span class="input-group-text">Pcs</span>
                            </div>
                            <small class="text-muted fst-italic">Pastikan jumlah tidak melebihi stok tersedia.</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase">Penerima / Tujuan</label>
                            <input type="text" name="penerima" class="form-control" placeholder="Cth: Bagian Produksi / Pak Budi" required>
                        </div>

                        <button type="submit" class="btn btn-danger w-100 py-2 fw-bold">
                            <i class="fas fa-save me-2"></i> Simpan Transaksi
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-dark"><i class="fas fa-history me-2"></i> Riwayat Pengeluaran</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Tanggal</th>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Penerima</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query_history = "SELECT barang_keluar.*, barang.nama_barang, barang.kode_barang 
                                                  FROM barang_keluar 
                                                  JOIN barang ON barang_keluar.barang_id = barang.id 
                                                  ORDER BY barang_keluar.id DESC LIMIT 10";
                                
                                $history = mysqli_query($conn, $query_history);
                                
                                if(mysqli_num_rows($history) == 0):
                                    echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Belum ada barang keluar.</td></tr>";
                                else:
                                    while($h = mysqli_fetch_array($history)):
                                ?>
                                <tr>
                                    <td class="ps-4 small"><?= date('d/m/Y', strtotime($h['tanggal'])); ?></td>
                                    <td>
                                        <span class="fw-bold text-dark"><?= $h['nama_barang']; ?></span><br>
                                        <small class="text-muted"><?= $h['kode_barang']; ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">
                                            - <?= $h['jumlah']; ?>
                                        </span>
                                    </td>
                                    <td class="small text-muted"><?= $h['penerima']; ?></td>
                                </tr>
                                <?php 
                                    endwhile; 
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                    <div class="card-footer bg-white border-top-0 text-center py-3">
                        <a href="riwayat_keluar.php" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                            <i class="fas fa-list-ul me-2"></i> Lihat Semua Riwayat
                        </a>
                    </div>
            </div>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>