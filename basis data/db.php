<?php
$host = 'localhost';
$username = 'root'; // Default username
$password = ''; // Kosong jika Anda tidak mengatur password untuk MySQL
$database = 'datapasien_db'; // Nama database Anda

// Buat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
