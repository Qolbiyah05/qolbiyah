<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil kata kunci pencarian jika ada
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

// Query untuk mengambil data peminjaman berdasarkan pencarian
$query = "SELECT peminjaman.*, users.nama, buku.judul 
          FROM peminjaman 
          JOIN users ON peminjaman.user_id = users.id 
          JOIN buku ON peminjaman.buku_id = buku.id 
          WHERE users.nama LIKE ? OR buku.judul LIKE ?
          ORDER BY peminjaman.tanggal_pinjam DESC";
$stmt = $conn->prepare($query);
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
        <h3>ADMIN</h3>
        <a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="kelola_buku.php"><i class="fas fa-book"></i> Kelola Buku</a>
        <a href="kelola_anggota.php"><i class="fas fa-users"></i> Kelola Anggota</a>
        <a href="kelola_peminjaman.php"><i class="fas fa-list"></i> Kelola Peminjaman</a>
        <a href="laporan_peminjaman.php"><i class="fas fa-file-alt"></i> Laporan Peminjaman</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Keluar</a>
    </div>

    <div class="main-content">
        <div class="container">
            <h2 class="mb-4">Kelola Peminjaman</h2>

            <!-- Form Pencarian -->
            <form action="kelola_peminjaman.php" method="get" class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="cari" placeholder="Cari Anggota atau Buku" value="<?= htmlspecialchars($cari) ?>">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Cari</button>
                </div>
            </form>

            <!-- Tombol Tambah Peminjaman -->
            <a href="tambah_peminjaman.php" class="btn btn-success mb-3">Tambah Peminjaman</a>

            <!-- Tabel Peminjaman -->
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Anggota</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['judul']) ?></td>
                            <td><?= htmlspecialchars($row['tanggal_pinjam']) ?></td>
                            <td><?= htmlspecialchars($row['tanggal_kembali']) ?></td>
                            <td><?= ucfirst(htmlspecialchars($row['status'])) ?></td>
                            <td>
                                <!-- Edit Link -->
                                <a href="edit_peminjaman.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <!-- Hapus Link -->
                                <a href="hapus_peminjaman.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus peminjaman ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Button to return to Dashboard -->
            <a href="dashboard_admin.php" class="btn btn-secondary">Kembali ke Dashboard Admin</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
