<?php
include 'koneksi.php';
session_start();

// Cek apakah user sudah login dan memiliki peran anggota
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'anggota') {
    header("Location: login.php");
    exit();
}

$peminjaman_id = isset($_GET['id']) ? mysqli_real_escape_string($koneksi, $_GET['id']) : null;
$message = "";

if ($peminjaman_id) {
    // Ambil data peminjaman
    $query = "SELECT * FROM peminjaman WHERE id = '$peminjaman_id'";
    $result = $koneksi->query($query);
    $data = $result->fetch_assoc();

    if ($data) {
        $buku_id = $data['buku_id'];

        // Update status peminjaman menjadi 'dikembalikan'
        $update_peminjaman = "UPDATE peminjaman SET status = 'dikembalikan' WHERE id = '$peminjaman_id'";
        if ($koneksi->query($update_peminjaman) === TRUE) {
            // Tambahkan kembali jumlah buku yang tersedia
            $update_buku = "UPDATE buku SET tersedia = tersedia + 1 WHERE id = '$buku_id'";
            $koneksi->query($update_buku);
            $message = "<div class='alert alert-success'>Buku berhasil dikembalikan!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Gagal mengembalikan buku. Silakan coba lagi.</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Data peminjaman tidak ditemukan.</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian Buku</title>

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            min-height: 100vh;
            margin: 0;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            padding: 20px;
            min-height: 100vh;
        }

        .sidebar a {
            text-decoration: none;
            color: white;
            display: block;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }

        footer {
            text-align: center;
            padding: 10px;
            background: #e9ecef;
            border-top: 1px solid #ddd;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center">ANGGOTA</h4>
        <nav>
            <a href="dashboard_anggota.php"><i class="fas fa-home me-2"></i> Beranda</a>
            <a href="daftar_pinjaman.php"><i class="fas fa-book me-2"></i> Buku Dipinjam</a>
            <a href="histori_peminjaman.php"><i class="fas fa-history me-2"></i> Histori Peminjaman</a>
            <div class="dropdown-divider"></div>
            <a href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Keluar</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <h2 class="text-center mb-4">Pengembalian Buku</h2>
            <?= $message ?>

            <div class="text-center">
                <a href="daftar_pinjaman.php" class="btn btn-secondary">Kembali ke Daftar Peminjaman</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Perpustakaan Qolbyhh</p>
    </footer>
</body>
</html>
