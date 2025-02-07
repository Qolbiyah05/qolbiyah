<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'anggota') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT peminjaman.*, buku.judul FROM peminjaman 
          JOIN buku ON peminjaman.buku_id = buku.id 
          WHERE peminjaman.user_id = '$user_id' AND peminjaman.status = 'dipinjam'";

$result = $koneksi->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peminjaman</title>
    
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
            padding: 20px;
        }

        .table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        footer {
            text-align: center;
            padding: 10px;
            background: #e9ecef;
            border-top: 1px solid #ddd;
            position: fixed;
            width: 100%;
            bottom: 0;
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
        <div class="container mt-4">
            <h2>Daftar Buku yang Dipinjam</h2>

            <table class="table table-striped table-bordered mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['judul']); ?></td>
                            <td><?= htmlspecialchars($row['tanggal_pinjam']); ?></td>
                            <td><?= htmlspecialchars($row['tanggal_kembali']); ?></td>
                            <td>
                                <a href="kembalikan_buku.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">
                                    <i class="fas fa-undo"></i> Kembalikan
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <a href="dashboard_anggota.php" class="btn btn-secondary mt-3">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Perpustakaan Qolbyhh.</p>
    </footer>

</body>
</html>
