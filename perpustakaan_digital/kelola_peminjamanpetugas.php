<?php
include 'koneksi.php';
session_start();

// Cek jika user bukan petugas atau belum login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'petugas') {
    header("Location: login.php");
    exit();
}

// Query untuk mengambil data peminjaman yang masih "dipinjam"
$query = "SELECT peminjaman.*, users.nama, buku.judul 
          FROM peminjaman 
          JOIN users ON peminjaman.user_id = users.id 
          JOIN buku ON peminjaman.buku_id = buku.id 
          WHERE peminjaman.status = 'dipinjam' 
          ORDER BY peminjaman.tanggal_pinjam DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Peminjaman</title>
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
            margin-bottom: 5px;
        }
        .sidebar a:hover, .sidebar .active {
            background-color: gray;
        }
        .main-content {
            flex: 1;
            padding: 20px;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        footer {
            margin-top: auto;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Petugas</h3>
        <a href="dashboard_petugas.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="kelola_peminjaman.php"><i class="fas fa-list"></i> Kelola Peminjaman</a>
        <a href="kelola_pengembalian.php"><i class="fas fa-undo-alt"></i> Kelola Pengembalian</a>
        <a href="laporan_peminjaman.php"><i class="fas fa-file-alt"></i> Lihat Laporan Peminjaman</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Keluar</a>
    </div>

    <div class="main-content">
        <h2>Daftar Peminjaman Buku</h2>
        <!-- Tabel Daftar Peminjaman -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['judul']) ?></td>
                        <td><?= htmlspecialchars($row['tanggal_pinjam']) ?></td>
                        <td><a href="proses_pengembalian.php?id=<?= $row['id'] ?>" class="btn btn-primary">Konfirmasi Pengembalian</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <br>
        <a href="dashboard_petugas.php" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</body>
</html>
