<?php
include '../config/database.php';
// Ambil ID Transaksi dari URL
$id = $_GET['id'];

// Ambil Detail Transaksi
$query = mysqli_query($conn, "SELECT barang_keluar.*, barang.kode_barang, barang.nama_barang 
                              FROM barang_keluar 
                              JOIN barang ON barang_keluar.barang_id = barang.id 
                              WHERE barang_keluar.id = '$id'");
$data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Surat Jalan - <?= $data['id']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print { .no-print { display: none; } }
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .surat-jalan { border: 2px solid #000; padding: 30px; margin: 20px auto; max-width: 800px; }
    </style>
</head>
<body>

    <div class="no-print container mt-3">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
    </div>

    <div class="surat-jalan">
        <div class="row mb-4 border-bottom pb-3">
            <div class="col-6">
                <h3 class="fw-bold">SURAT JALAN</h3>
                <small>No. Transaksi: OUT-<?= date('Ymd', strtotime($data['tanggal'])) . "-" . $data['id']; ?></small>
            </div>
            <div class="col-6 text-end">
                <h5 class="fw-bold">PT. INVENTARIS MAJU JAYA</h5>
                <p class="mb-0">Gudang Utama</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-6">
                <strong>Kepada Yth:</strong><br>
                <?= $data['penerima']; ?><br>
                (Bagian Produksi / Tujuan)
            </div>
            <div class="col-6 text-end">
                <strong>Tanggal Keluar:</strong><br>
                <?= date('d F Y', strtotime($data['tanggal'])); ?>
            </div>
        </div>

        <table class="table table-bordered border-black text-center">
            <thead class="table-light border-black">
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah (Qty)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $data['kode_barang']; ?></td>
                    <td><?= $data['nama_barang']; ?></td>
                    <td class="fw-bold fs-5"><?= $data['jumlah']; ?> Pcs</td>
                </tr>
            </tbody>
        </table>

        <div class="row mt-5 text-center">
            <div class="col-4">
                <p>Penerima,</p>
                <br><br><br>
                <p>( <?= $data['penerima']; ?> )</p>
            </div>
            <div class="col-4">
                <p>Supir / Kurir,</p>
                <br><br><br>
                <p>( ....................... )</p>
            </div>
            <div class="col-4">
                <p>Hormat Kami,</p>
                <br><br><br>
                <p>( Admin Gudang )</p>
            </div>
        </div>
    </div>

</body>
</html>