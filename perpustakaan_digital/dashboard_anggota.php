<?php
include 'koneksi.php';
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'anggota') {
    header("Location: login.php");
    exit();
}


// Ambil daftar buku yang tersedia
$query = "SELECT * FROM buku WHERE tersedia > 0";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Anggota</title>
    <!-- Bootstrap CSS -->
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
            min-height: 100vh;
            padding: 20px;
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
            padding: 40px;
        }

        .card {
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
        }

        .book-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }

        .footer {
            text-align: center;
            padding: 15px;
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
        <h2 class="mb-4">Selamat Datang, <?= isset($_SESSION['nama']) ? htmlspecialchars($_SESSION['nama']) : "User"; ?>!</h2>

            <p class="lead">Berikut adalah daftar buku yang tersedia untuk dipinjam:</p>

            <div class="row">
            <?php while ($buku = $result->fetch_assoc()) { 
                // Path gambar buku
                $foto_path = !empty($buku['foto']) ? "uploads/" . htmlspecialchars($buku['foto']) : "uploads/default.jpg"; 
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100">
                        <img src="<?= $foto_path; ?>" alt="Foto Buku" class="book-image">
                        <div class="card-body">
                            <h5 class="card-title text-truncate" title="<?= htmlspecialchars($buku['judul']); ?>">
                                <?= htmlspecialchars($buku['judul']); ?>
                            </h5>
                            <p class="card-text"><strong>Penulis:</strong> <?= htmlspecialchars($buku['penulis']); ?></p>
                            <p class="card-text"><strong>Jumlah Tersedia:</strong> <?= $buku['tersedia']; ?></p>
                            <a href="pinjam_buku.php?id=<?= $buku['id']; ?>" class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-book"></i> Pinjam
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Perpustakaan Qolbyhh.</p>
    </footer>
</body>
</html>
