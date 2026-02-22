<?php
include '../config/database.php';

// 1. Ambil Tanggal dari URL dulu (sebelum header)
$tgl_mulai   = isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : '';
$tgl_selesai = isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : '';

// 2. Buat Logika Nama File Dinamis
if(!empty($tgl_mulai) && !empty($tgl_selesai)){
    // Kita ubah formatnya dari 2026-02-01 menjadi 01-02-2026 agar lebih enak dibaca orang Indonesia
    $periode_awal = date('d-m-Y', strtotime($tgl_mulai));
    $periode_akhir = date('d-m-Y', strtotime($tgl_selesai));
    
    // Hasil: Laporan_Masuk_01-02-2026_sd_28-02-2026.xls
    $nama_file = "Laporan_Masuk_" . $periode_awal . "_sd_" . $periode_akhir . ".xls";
} else {
    // Jika tidak ada filter tanggal
    $nama_file = "Laporan_Masuk_Semua_Periode.xls";
}

// 3. Kirim Header (Browser akan mendownload dengan nama variabel di atas)
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=$nama_file");
?>

<h3>DATA BARANG MASUK</h3>
<p>Periode: <?= ($tgl_mulai && $tgl_selesai) ? date('d M Y', strtotime($tgl_mulai)) . " s/d " . date('d M Y', strtotime($tgl_selesai)) : "Semua Data"; ?></p>

<table border="1">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th style="width: 50px;">No</th>
            <th style="width: 120px;">Tanggal</th>
            <th style="width: 100px;">Kode Barang</th>
            <th style="width: 250px;">Nama Barang</th>
            <th style="width: 80px;">Jml Masuk</th>
            <th style="width: 200px;">Supplier / Keterangan</th>
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
        $sql .= " ORDER BY tanggal ASC";

        $query = mysqli_query($conn, $sql);
        $no = 1;
        while($row = mysqli_fetch_array($query)):
        ?>
        <tr>
            <td style="text-align: center;"><?= $no++; ?></td>
            <td style="text-align: center;"><?= date('d/m/Y', strtotime($row['tanggal'])); ?></td>
            <td style="text-align: center;"><?= $row['kode_barang']; ?></td>
            <td><?= $row['nama_barang']; ?></td>
            <td style="text-align: center;"><?= $row['jumlah']; ?></td>
            <td><?= $row['keterangan']; ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>