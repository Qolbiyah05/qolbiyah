<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'petugas') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id_peminjaman = $_GET['id'];

    // Ambil data peminjam
    $query = "SELECT users.email, users.username, buku.judul FROM peminjaman 
              JOIN users ON peminjaman.user_id = users.id 
              JOIN buku ON peminjaman.buku_id = buku.id
              WHERE peminjaman.id = $id_peminjaman";

    $result = $conn->query($query);
    $data = $result->fetch_assoc();

    $email_peminjam = $data['email'];
    $nama_peminjam = $data['username'];
    $judul_buku = $data['judul'];

    // Simulasi pengiriman notifikasi (bisa dikembangkan ke email)
    echo "Notifikasi keterlambatan telah dikirim ke $email_peminjam:<br>";
    echo "Halo $nama_peminjam, Anda terlambat mengembalikan buku '$judul_buku'. Harap segera dikembalikan.";

    // Redirect kembali ke daftar peminjaman
    echo "<br><a href='kelola_peminjaman.php'>Kembali</a>";
}
?>
