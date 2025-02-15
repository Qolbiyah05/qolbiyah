<?php
include 'koneksi.php';
session_start();

// Memastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Memeriksa apakah parameter ID ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus buku berdasarkan ID
    $query = "DELETE FROM buku WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);

    // Mengeksekusi query
    if ($stmt->execute()) {
        // Jika berhasil, alihkan kembali ke halaman kelola buku dengan pesan sukses
        $_SESSION['message'] = 'Buku berhasil dihapus.';
    } else {
        // Jika gagal, alihkan kembali dengan pesan error
        $_SESSION['message'] = 'Gagal menghapus buku.';
    }

    // Redirect kembali ke halaman kelola buku
    header("Location: kelola_buku.php");
    exit();
} else {
    // Jika ID tidak ditemukan di URL, redirect ke kelola buku
    header("Location: kelola_buku.php");
    exit();
}
?>
