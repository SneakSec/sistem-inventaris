<?php
include '../config/database.php';
$judul = "Riwayat Lengkap Barang Masuk";
include '../layout/header.php';
include '../layout/sidebar.php';
?>

<div class="container-fluid px-4">
    
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-dark">Arsip Barang Masuk</h2>
            <p class="text-muted mb-0">Data lengkap seluruh transaksi pemasukan barang.</p>
        </div>
        <a href="barang_masuk.php" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        
        <form action="" method="GET" class="d-flex gap-2">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="fas fa-calendar text-muted"></i></span>
                <input type="date" name="tgl_mulai" class="form-control border-start-0" 
                       value="<?= isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : ''; ?>" 
                       title="Dari Tanggal">
            </div>
            
            <span class="align-self-center fw-bold">-</span>
            
            <div class="input-group">
                <input type="date" name="tgl_selesai" class="form-control border-end-0" 
                       value="<?= isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : ''; ?>" 
                       title="Sampai Tanggal">
                <button type="submit" class="btn btn-primary border-start-0" title="Terapkan Filter">
                    <i class="fas fa-filter"></i>
                </button>
            </div>

            <?php if(isset($_GET['tgl_mulai']) && $_GET['tgl_mulai'] != ''): ?>
                <a href="riwayat_masuk.php" class="btn btn-light border" title="Reset Filter">
                    <i class="fas fa-sync-alt text-muted"></i>
                </a>
            <?php endif; ?>
        </form>

        <div>
            <button type="button" class="btn btn-dark shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#modalCetak">
                <i class="fas fa-print me-2"></i> Menu Laporan
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-5">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="ps-4 py-3">No</th>
                            <th>Tanggal</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Masuk</th>
                            <th>Keterangan / Supplier</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Logika Filter Tanggal untuk Tampilan Tabel
                        $tgl_mulai   = isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : '';
                        $tgl_selesai = isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : '';
                        
                        $sql = "SELECT barang_masuk.*, barang.nama_barang, barang.kode_barang 
                                FROM barang_masuk 
                                JOIN barang ON barang_masuk.barang_id = barang.id";
                        
                        // Jika ada filter tanggal
                        if(!empty($tgl_mulai) && !empty($tgl_selesai)){
                            $sql .= " WHERE tanggal BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                        }
                        
                        $sql .= " ORDER BY tanggal DESC, id DESC";

                        $query = mysqli_query($conn, $sql);
                        $no = 1;
                        $total_item = 0;

                        if(mysqli_num_rows($query) == 0):
                            echo "<tr><td colspan='6' class='text-center py-5 text-muted'>Tidak ada data ditemukan pada periode ini.</td></tr>";
                        else:
                            while($row = mysqli_fetch_array($query)):
                                $total_item += $row['jumlah'];
                        ?>
                        <tr>
                            <td class="ps-4 text-center"><?= $no++; ?></td>
                            <td><?= date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                            <td><span class="badge bg-light text-dark border"><?= $row['kode_barang']; ?></span></td>
                            <td class="fw-bold"><?= $row['nama_barang']; ?></td>
                            <td>
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                    + <?= $row['jumlah']; ?>
                                </span>
                            </td>
                            <td class="text-muted small"><?= $row['keterangan']; ?></td>
                        </tr>
                        <?php 
                            endwhile; 
                        endif;
                        ?>
                    </tbody>
                    <?php if(mysqli_num_rows($query) > 0): ?>
                    <tfoot class="bg-light fw-bold">
                        <tr>
                            <td colspan="4" class="text-end py-3">TOTAL BARANG MASUK (Periode Ini):</td>
                            <td colspan="2" class="text-success py-3">+ <?= $total_item; ?> Item</td>
                        </tr>
                    </tfoot>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="modalCetak" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-file-alt me-2"></i> Cetak Laporan Masuk
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <form method="GET" target="_blank"> 
                <div class="modal-body p-4">
                    <div class="alert alert-info small mb-3">
                        <i class="fas fa-info-circle me-1"></i> 
                        Silakan pilih periode data yang ingin dicetak atau diunduh.
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-bold small text-muted">Dari Tanggal</label>
                            <input type="date" name="tgl_mulai" class="form-control" required value="<?= date('Y-m-01'); ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small text-muted">Sampai Tanggal</label>
                            <input type="date" name="tgl_selesai" class="form-control" required value="<?= date('Y-m-d'); ?>">
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light d-flex">
                    <button type="submit" formaction="cetak_laporan_masuk.php" class="btn btn-danger flex-fill">
                        <i class="fas fa-file-pdf me-2"></i> Download PDF
                    </button>
                    
                    <button type="submit" formaction="excel_masuk.php" class="btn btn-success flex-fill">
                        <i class="fas fa-file-excel me-2"></i> Download Excel
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>