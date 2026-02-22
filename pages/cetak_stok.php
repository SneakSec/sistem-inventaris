<?php
// Pastikan path ke config benar.
// Karena file ini ada di folder pages, kita harus mundur satu langkah (../)
include '../config/database.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS KHUSUS PRINT */
        @media print {
            .no-print { display: none !important; } /* Tombol print hilang saat dicetak */
        }
        body { font-family: Arial, sans-serif; }
        .kop-surat { border-bottom: 3px solid black; padding-bottom: 10px; margin-bottom: 20px; }
    </style>
</head>
<body class="p-5">

    <div class="no-print mb-4">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Cetak / Simpan PDF
        </button>
        <a href="../index.php" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>

    <div class="text-center kop-surat">
        <h2 class="fw-bold">PT. INVENTARIS MAJU JAYA</h2>
        <p>Jl. Teknologi No. 12, Jakarta Timur - Indonesia</p>
        <p>Telp: (021) 555-1234 | Email: admin@inventaris.com</p>
    </div>

    <div class="text-center mb-4">
        <h4>LAPORAN STOK BARANG (STOCK OPNAME)</h4>
        <p class="text-muted">Per Tanggal: <?= date('d F Y'); ?></p>
    </div>

    <table class="table table-bordered border-dark">
        <thead class="table-light text-center border-black">
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode Barang</th>
                <th>Nama Barang</th>
                <th width="10%">Stok</th>
                <th width="10%">Satuan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query SEDERHANA (Tanpa Join Kategori)
            $query = mysqli_query($conn, "SELECT * FROM barang ORDER BY nama_barang ASC");
            
            $no = 1;
            while($row = mysqli_fetch_array($query)):
            ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td class="text-center"><?= $row['kode_barang']; ?></td>
                <td><?= $row['nama_barang']; ?></td>
                
                <td class="text-center fw-bold">
                    <?= $row['stok']; ?>
                </td>
                
                <td class="text-center"><?= $row['satuan']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-end mt-5">
        <div class="text-center" style="width: 200px;">
            <p>Jakarta, <?= date('d F Y'); ?></p>
            <p>Kepala Gudang,</p>
            <br><br><br>
            <p class="fw-bold text-decoration-underline">Ganti Nama</p>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>