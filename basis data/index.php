<?php
include 'db.php';

$sql = "CREATE TABLE IF NOT EXISTS admin (
    id INT(11) NOT NULL,
    name VARCHAR(11) NOT NULL,
    password VARCHAR(11) NOT NULL
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Tabel 'admin' berhasil dibuat.<br>";
} else {
    echo "Gagal membuat tabel: " . $conn->error . "<br>";
}
?>

<?php
// Memulai session
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>

<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "datapasien_db");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Logika untuk mencari data
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM pasien_bpjs WHERE nama LIKE '%$search%' OR no_bpjs LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM pasien_bpjs";
}

$result = $conn->query($sql);
?>
