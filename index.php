<?php
$judul = "Dashboard Utama";
include 'config/database.php';
include 'layout/header.php';
include 'layout/sidebar.php';

// --- LOGIKA QUERY DATA KARTU ATAS ---
$total_barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM barang"))['total'];
$stok_krisis  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as krisis FROM barang WHERE stok <= 10"))['krisis'];
$aset         = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(stok) as total_aset FROM barang"))['total_aset'];
if($aset == null) $aset = 0;
?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-dark">Dashboard</h2>
            <p class="text-muted mb-0">Selamat datang di Sistem Manajemen Inventaris</p>
        </div>
        <div class="date text-muted">
            <i class="fas fa-calendar-alt me-2"></i> <?= date('l, d M Y'); ?>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card card-stat p-3 mb-3 border-start border-4 border-primary shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Total Jenis Barang</p>
                            <h3 class="fw-bold text-dark mb-0"><?= $total_barang; ?></h3>
                        </div>
                        <div class="icon-box bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                            <i class="fas fa-box fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-stat p-3 mb-3 border-start border-4 border-danger shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Stok Menipis</p>
                            <h3 class="fw-bold text-danger mb-0"><?= $stok_krisis; ?></h3>
                        </div>
                        <div class="icon-box bg-danger bg-opacity-10 p-3 rounded-circle text-danger">
                            <i class="fas fa-exclamation-triangle fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-stat p-3 mb-3 border-start border-4 border-success shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Total Aset Fisik</p>
                            <h3 class="fw-bold text-success mb-0"><?= $aset; ?> Unit</h3>
                        </div>
                        <div class="icon-box bg-success bg-opacity-10 p-3 rounded-circle text-success">
                            <i class="fas fa-warehouse fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-dark">Statistik Transaksi (7 Hari Terakhir)</h6>
                </div>
                <div class="card-body">
                    <canvas id="myChart" height="120"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-danger">Perlu Perhatian (Low Stock)</h6>
                </div>
                <div class="list-group list-group-flush">
                    <?php
                    $limit = mysqli_query($conn, "SELECT * FROM barang WHERE stok <= 10 ORDER BY stok ASC LIMIT 5");
                    if(mysqli_num_rows($limit) == 0):
                        echo "<div class='p-4 text-center text-muted small'>Semua stok aman!</div>";
                    else:
                        while($l = mysqli_fetch_array($limit)):
                    ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold d-block"><?= $l['nama_barang']; ?></span>
                                <small class="text-muted"><?= $l['kode_barang']; ?></small>
                            </div>
                            <span class="badge bg-danger rounded-pill"><?= $l['stok']; ?> <?= $l['satuan']; ?></span>
                        </div>
                    <?php 
                        endwhile; 
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-4 shadow-sm">
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
            <h5 class="fw-bold mb-0 text-dark">Data Stok Barang</h5>
            
            <div class="d-flex gap-2">
                <form action="" method="GET" class="d-flex">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control border-end-0 rounded-start border-secondary" 
                               placeholder="Cari Kode, Nama & Status" 
                               value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">
                        <button class="btn btn-outline-secondary border-start-0 bg-white" type="submit">
                            <i class="fas fa-search text-muted"></i>
                        </button>
                    </div>
                </form>

                <a href="pages/cetak_stok.php" target="_blank" class="btn btn-success rounded px-3 d-flex align-items-center" title="Cetak Laporan">
                    <i class="fas fa-print me-2"></i> Cetak Laporan Stok
                </a>

                <?php if($_SESSION['role'] == 'admin'): ?>
                <a href="tambah.php" class="btn btn-primary rounded px-3 d-flex align-items-center">
                    <i class="fas fa-plus me-2"></i> Baru
                </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle table-hover">
                <thead class="bg-light">
                    <tr>
                        <th width="15%" class="ps-3">Kode</th>
                        
                        <th >Produk</th>
                        
                        <th width="15%" class="text-center">Stok</th>
                        
                        <th width="15%" class="text-center">Status</th>
                        
                        <?php if($_SESSION['role'] == 'admin'): ?>
                            <th width="15%" class="text-end pe-3">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // --- LOGIKA PENCARIAN (Sama seperti sebelumnya) ---
                    if(isset($_GET['keyword'])) {
                        $keyword = $_GET['keyword'];
                        $keyword = mysqli_real_escape_string($conn, $keyword);
                        
                        $extra_logic = "";
                        if(strtolower($keyword) == 'kritis' || strtolower($keyword) == 'low') {
                            $extra_logic = " OR stok <= 10";
                        } elseif(strtolower($keyword) == 'aman') {
                            $extra_logic = " OR stok > 10";
                        }

                        $query_sql = "SELECT * FROM barang 
                                    WHERE (kode_barang LIKE '%$keyword%' 
                                    OR nama_barang LIKE '%$keyword%' 
                                    $extra_logic) 
                                    ORDER BY id DESC";
                    } else {
                        $query_sql = "SELECT * FROM barang ORDER BY id ASC LIMIT 10";
                    }

                    $query = mysqli_query($conn, $query_sql);

                    if(mysqli_num_rows($query) == 0):
                    ?>
                        <tr>
                            <td colspan="<?= ($_SESSION['role'] == 'admin') ? 5 : 4; ?>" class="text-center py-5 text-muted">
                                <i class="fas fa-search fa-3x mb-3 opacity-25"></i><br>
                                Data tidak ditemukan.
                            </td>
                        </tr>
                    <?php
                    else:
                        while($row = mysqli_fetch_array($query)):
                    ?>
                    <tr>
                        <td class="ps-3 text-muted fw-bold">
                            <span class="badge bg-light text-dark border">#<?= $row['kode_barang']; ?></span>
                        </td>
                        <td>
                            <span class="fw-bold text-dark"><?= $row['nama_barang']; ?></span><br>
                            <small class="text-muted"><?= $row['satuan']; ?></small>
                        </td>
                        <td class="text-center fw-bold fs-5"><?= $row['stok']; ?></td>
                        <td class="text-center">
                            <?php if($row['stok'] <= 10): ?>
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-1 rounded-pill">
                                    <i class="fas fa-exclamation-circle me-1"></i> Kritis
                                </span>
                            <?php else: ?>
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill">
                                    <i class="fas fa-check-circle me-1"></i> Aman
                                </span>
                            <?php endif; ?>
                        </td>
                        
                        <?php if($_SESSION['role'] == 'admin'): ?>
                        <td class="text-end pe-3">
                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-light text-primary border me-1" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-light text-danger border" onclick="return confirm('Hapus?')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                        <?php endif; ?>
                        
                    </tr>
                    <?php 
                        endwhile; 
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
        
        <?php if(isset($_GET['keyword'])): ?>
            <div class="mt-3">
                <a href="index.php" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-sync-alt me-1"></i> Reset Pencarian
                </a>
            </div>
        <?php endif; ?>

    </div>

<?php 
// --- SCRIPT GRAFIK (Chart.js) ---
$labels = [];
$data_masuk = [];
$data_keluar = [];

for ($i = 6; $i >= 0; $i--) {
    $tgl = date('Y-m-d', strtotime("-$i days"));
    $labels[] = date('d M', strtotime($tgl));

    $q_masuk = mysqli_query($conn, "SELECT SUM(jumlah) as total FROM barang_masuk WHERE tanggal = '$tgl'");
    $h_masuk = mysqli_fetch_assoc($q_masuk);
    $data_masuk[] = $h_masuk['total'] ? $h_masuk['total'] : 0;

    $q_keluar = mysqli_query($conn, "SELECT SUM(jumlah) as total FROM barang_keluar WHERE tanggal = '$tgl'");
    $h_keluar = mysqli_fetch_assoc($q_keluar);
    $data_keluar[] = $h_keluar['total'] ? $h_keluar['total'] : 0;
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('myChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($labels); ?>, 
            datasets: [
                {
                    label: 'Barang Masuk',
                    data: <?= json_encode($data_masuk); ?>,
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    borderWidth: 2, tension: 0.4, fill: true
                },
                {
                    label: 'Barang Keluar',
                    data: <?= json_encode($data_keluar); ?>,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    borderWidth: 2, tension: 0.4, fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>

<?php include 'layout/footer.php'; ?>