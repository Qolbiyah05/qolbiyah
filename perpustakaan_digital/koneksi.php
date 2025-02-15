<?php
$host = "localhost"; // Sesuaikan dengan konfigurasi MySQL Anda
$user = "root";      // Username default XAMPP
$pass = "";          // Kosongkan jika tidak ada password
$db   = "perpustakaan_digital"; // Sesuaikan dengan nama database Anda

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
