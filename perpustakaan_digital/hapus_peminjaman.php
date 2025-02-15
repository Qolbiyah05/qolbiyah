<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Mengambil ID peminjaman dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Menghapus peminjaman dari database
    $query = "DELETE FROM peminjaman WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        // Redirect setelah berhasil menghapus
        header("Location: kelola_peminjaman.php?message=success");
        exit();
    } else {
        // Jika ada error
        echo "Terjadi kesalahan dalam menghapus peminjaman.";
    }
} else {
    echo "ID peminjaman tidak ditemukan.";
}
?>
