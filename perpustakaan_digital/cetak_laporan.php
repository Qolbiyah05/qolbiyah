<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil filter tanggal dari URL
$tanggal_mulai = isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : '';
$tanggal_selesai = isset($_GET['tanggal_selesai']) ? $_GET['tanggal_selesai'] : '';

// Query default tanpa filter
$query = "SELECT peminjaman.*, users.nama, buku.judul 
          FROM peminjaman 
          JOIN users ON peminjaman.user_id = users.id 
          JOIN buku ON peminjaman.buku_id = buku.id ";

// Jika filter tanggal digunakan
if (!empty($tanggal_mulai) && !empty($tanggal_selesai)) {
    $query .= " WHERE peminjaman.tanggal_pinjam BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'";
}

$query .= " ORDER BY peminjaman.tanggal_pinjam DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Peminjaman</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body onload="window.print()">
    <h2>Laporan Peminjaman Buku</h2>
    <p><strong>Periode:</strong> <?= $tanggal_mulai ?> - <?= $tanggal_selesai ?></p>
    
    <table>
        <tr>
            <th>Nama Anggota</th>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['judul'] ?></td>
                <td><?= $row['tanggal_pinjam'] ?></td>
                <td><?= $row['tanggal_kembali'] ? $row['tanggal_kembali'] : '-' ?></td>
                <td><?= ucfirst($row['status']) ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
