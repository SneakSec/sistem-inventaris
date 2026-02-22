<?php
include '../config/database.php';
$judul = "Transaksi Barang Masuk";
include '../layout/header.php';
include '../layout/sidebar.php';
?>

<div class="container-fluid px-4">
    
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-dark">Barang Masuk</h2>
            <p class="text-muted mb-0">Catat penambahan stok dan lihat riwayat pemasukan.</p>
        </div>
    </div>

    <div class="row">
        
        <div class="col-md-5 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-plus-circle me-2"></i> Input Stok Baru</h6>
                </div>
                <div class="card-body">
                    <form action="proses_masuk.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase">Tanggal Masuk</label>
                            <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase">Pilih Barang</label>
                            <select name="barang_id" class="form-select" required>
                                <option value="">-- Pilih Barang --</option>
                                <?php
                                $ambil = mysqli_query($conn, "SELECT * FROM barang ORDER BY nama_barang ASC");
                                while($b = mysqli_fetch_array($ambil)){
                                ?>
                                    <option value="<?= $b['id']; ?>">
                                        <?= $b['kode_barang'] . " - " . $b['nama_barang'] . " (Sisa: " . $b['stok'] . ")"; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase">Jumlah Masuk</label>
                            <div class="input-group">
                                <input type="number" name="jumlah" class="form-control" min="1" required placeholder="0">
                                <span class="input-group-text">Pcs</span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase">Supplier / Ket</label>
                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Cth: Dari PT. Gudang Garam" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold">
                            <i class="fas fa-save me-2"></i> Simpan Transaksi
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-history me-2"></i> Riwayat Pemasukan Terakhir</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Tanggal</th>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Ket</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Kita lakukan JOIN tabel barang_masuk dengan tabel barang
                                // Supaya kita bisa menampilkan Nama Barang, bukan cuma ID-nya
                                $query_history = "SELECT barang_masuk.*, barang.nama_barang, barang.kode_barang 
                                                  FROM barang_masuk 
                                                  JOIN barang ON barang_masuk.barang_id = barang.id 
                                                  ORDER BY barang_masuk.id DESC LIMIT 10";
                                
                                $history = mysqli_query($conn, $query_history);
                                
                                if(mysqli_num_rows($history) == 0):
                                    echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Belum ada transaksi masuk.</td></tr>";
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
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">
                                            + <?= $h['jumlah']; ?>
                                        </span>
                                    </td>
                                    <td class="small text-muted fst-italic"><?= $h['keterangan']; ?></td>
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
                    <a href="riwayat_masuk.php" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                        <i class="fas fa-list-ul me-2"></i> Lihat Semua Riwayat
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include '../layout/footer.php'; ?>        