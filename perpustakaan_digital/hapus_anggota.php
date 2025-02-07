<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus data anggota berdasarkan ID
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        header("Location: kelola_anggota.php");
        exit();
    } else {
        echo "Error deleting record: " . $koneksi->error;
    }
} else {
    header("Location: kelola_anggota.php");
    exit();
}
