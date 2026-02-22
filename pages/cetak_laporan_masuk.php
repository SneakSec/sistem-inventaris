<?php
include '../config/database.php';

// Ambil Filter Tanggal dari URL (biar sesuai dengan yang dilihat user)
$tgl_mulai   = isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : '';
$tgl_selesai = isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : '';

// Judul Periode
$periode = "";
if(!empty($tgl_mulai) && !empty($tgl_selesai)){
    $periode = "Periode: " . date('d M Y', strtotime($tgl_mulai)) . " s/d " . date('d M Y', strtotime($tgl_selesai));
} else {
    $periode = "Semua Periode";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Barang Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print { .no-print { display: none !important; } }
        body { font-family: Arial, sans-serif; }
        .kop-surat { border-bottom: 3px solid black; padding-bottom: 10px; margin-bottom: 20px; }
        table { font-size: 12px; }
    </style>
</head>
<body class="p-4">

    <div class="no-print mb-4">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
    </div>

    <div class="text-center kop-surat">
        <h3 class="fw-bold">PT. INVENTARIS MAJU JAYA</h3>
        <p>Laporan Resmi Penerimaan Barang Gudang</p>
    </div>

    <div class="text-center mb-4">
        <h5 class="fw-bold">LAPORAN BARANG MASUK</h5>
        <p class="text-muted mb-0"><?= $periode; ?></p>
    </div>

    <table class="table table-bordered border-black">
        <thead class="table-light text-center align-middle border-black">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Keterangan / Supplier</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT barang_masuk.*, barang.nama_barang, barang.kode_barang 
                    FROM barang_masuk 
                    JOIN barang ON barang_masuk.barang_id = barang.id";

            if(!empty($tgl_mulai) && !empty($tgl_selesai)){
                $sql .= " WHERE tanggal BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
            }
            $sql .= " ORDER BY tanggal ASC"; // Urutkan dari tanggal lama ke baru (kronologis)

            $query = mysqli_query($conn, $sql);
            $no = 1;
            $total = 0;

            if(mysqli_num_rows($query) == 0):
                echo "<tr><td colspan='6' class='text-center fst-italic'>Tidak ada data pada periode ini.</td></tr>";
            else:
                while($row = mysqli_fetch_array($query)):
                    $total += $row['jumlah'];
            ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td class="text-center"><?= date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                <td class="text-center"><?= $row['kode_barang']; ?></td>
                <td><?= $row['nama_barang']; ?></td>
                <td class="text-center fw-bold">+ <?= $row['jumlah']; ?></td>
                <td><?= $row['keterangan']; ?></td>
            </tr>
            <?php 
                endwhile; 
            endif;
            ?>
        </tbody>
        <tfoot class="bg-light fw-bold">
            <tr>
                <td colspan="4" class="text-end">TOTAL PEMASUKAN:</td>
                <td colspan="2" class="text-start ps-4">+ <?= $total; ?> Item</td>
            </tr>
        </tfoot>
    </table>

    <div class="d-flex justify-content-end mt-5">
        <div class="text-center" style="width: 200px;">
            <p>Jakarta, <?= date('d F Y'); ?></p>
            <p>Admin Gudang,</p>
            <br><br><br>
            <p>( ....................... )</p>
        </div>
    </div>

</body>
</html>