<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'petugas') {
    header("Location: login.php");
    exit();
}

// Ambil kata kunci pencarian jika ada
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

// Query untuk mengambil data buku berdasarkan pencarian
$query = "SELECT * FROM buku WHERE judul LIKE ? OR penulis LIKE ?";
$stmt = $koneksi->prepare($query);
$searchTerm = "%" . $cari . "%"; // Menambahkan wildcard untuk pencarian
$stmt->bind_param('ss', $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Buku</title>
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
        .book-image {
            width: 100px;
            height: 150px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
    <h3>Petugas</h3>
        <a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="kelola_bukupetugas.php"><i class="fas fa-book"></i> Kelola Buku</a>
        <a href="kelola_anggota.php"><i class="fas fa-users"></i> Kelola Anggota</a>
        <a href="kelola_peminjaman.php"><i class="fas fa-list"></i> Kelola Peminjaman</a>
        <a href="laporan_peminjaman.php"><i class="fas fa-file-alt"></i> Laporan Peminjaman</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Keluar</a>
    </div>

    <div class="main-content">
        <div class="container">
            <h2 class="mb-4">Kelola Buku</h2>

            <!-- Form Pencarian -->
            <form action="kelola_bukupetugas.php" method="get" class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="cari" placeholder="Cari Buku" value="<?= htmlspecialchars($cari) ?>">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Cari</button>
                </div>
            </form>

            <a href="tambah_bukupetugas.php" class="btn btn-primary mb-3">Tambah Buku</a>

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Foto</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($buku = $result->fetch_assoc()) { ?>
                        <tr>
                            <td>
                                <?php if (!empty($buku['foto'])) { ?>
                                    <img src="uploads/<?= htmlspecialchars($buku['foto']) ?>" class="book-image" alt="Foto Buku">
                                <?php } else { ?>
                                    <img src="uploads/default.jpg" class="book-image" alt="Foto Buku Default">
                                <?php } ?>
                            </td>
                            <td><?= htmlspecialchars($buku['judul']) ?></td>
                            <td><?= htmlspecialchars($buku['penulis']) ?></td>
                            <td><?= htmlspecialchars($buku['tersedia']) ?></td>
                            <td>
                                <a href="edit_bukupetugas.php?id=<?= $buku['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="hapus_bukupetugas.php?id=<?= $buku['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <a href="dashboard_petugas.php" class="btn btn-secondary">Kembali ke Dashboard Admin</a>
        </div>
    </div>
</body>
</html>
