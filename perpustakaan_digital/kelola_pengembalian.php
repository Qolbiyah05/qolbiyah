<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'petugas') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id_peminjaman = $_GET['id'];
    $tanggal_kembali = date('Y-m-d');

    // Ambil data peminjaman
    $query = "SELECT tanggal_pinjam FROM peminjaman WHERE id = $id_peminjaman";
    $result = $conn->query($query);
    $data = $result->fetch_assoc();
    $tanggal_pinjam = $data['tanggal_pinjam'];

    // Hitung jumlah hari keterlambatan
    $batas_waktu = date('Y-m-d', strtotime($tanggal_pinjam . ' +7 days'));
    $terlambat = max((strtotime($tanggal_kembali) - strtotime($batas_waktu)) / (60 * 60 * 24), 0);
    $denda = $terlambat * 1000; // Rp 1.000 per hari terlambat

    // Update status peminjaman dan denda
    $query_update = "UPDATE peminjaman SET 
                     status = 'dikembalikan', 
                     tanggal_kembali = '$tanggal_kembali', 
                     denda = $denda 
                     WHERE id = $id_peminjaman";

    if ($conn->query($query_update)) {
        echo "Buku berhasil dikembalikan!";
        if ($denda > 0) {
            echo "<br>Denda yang harus dibayar: Rp " . number_format($denda, 0, ',', '.');
        }
    } else {
        echo "Gagal memperbarui status peminjaman.";
    }
}
?>
<br>
<a href="kelola_peminjamanpetugas.php</a>
