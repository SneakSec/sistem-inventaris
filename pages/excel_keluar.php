<?php
include '../config/database.php';

$tgl_mulai   = isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : '';
$tgl_selesai = isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : '';

if(!empty($tgl_mulai) && !empty($tgl_selesai)){
    $periode = date('d-m-Y', strtotime($tgl_mulai)) . "_sd_" . date('d-m-Y', strtotime($tgl_selesai));
    $nama_file = "Laporan_Keluar_" . $periode . ".xls";
} else {
    $nama_file = "Laporan_Keluar_Semua.xls";
}

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=$nama_file");
?>

<h3>DATA BARANG KELUAR</h3>
<p>Periode: <?= ($tgl_mulai) ? "$tgl_mulai s/d $tgl_selesai" : "Semua Data"; ?></p>

<table border="1">
    <thead>
        <tr style="background-color: #ffcccc;"> <th>No</th>
            <th>Tanggal</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Jumlah Keluar</th>
            <th>Penerima / Tujuan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT barang_keluar.*, barang.nama_barang, barang.kode_barang 
                FROM barang_keluar 
                JOIN barang ON barang_keluar.barang_id = barang.id";

        if(!empty($tgl_mulai) && !empty($tgl_selesai)){
            $sql .= " WHERE tanggal BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
        }
        $sql .= " ORDER BY tanggal ASC";

        $query = mysqli_query($conn, $sql);
        $no = 1;
        while($row = mysqli_fetch_array($query)):
        ?>
        <tr>
            <td style="text-align:center;"><?= $no++; ?></td>
            <td style="text-align:center;"><?= date('d/m/Y', strtotime($row['tanggal'])); ?></td>
            <td style="text-align:center;"><?= $row['kode_barang']; ?></td>
            <td><?= $row['nama_barang']; ?></td>
            <td style="text-align:center;"><?= $row['jumlah']; ?></td>
            <td><?= $row['penerima']; ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>