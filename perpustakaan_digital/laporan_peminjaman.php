<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil filter tanggal dari form jika ada
$tanggal_mulai = isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : '';
$tanggal_selesai = isset($_GET['tanggal_selesai']) ? $_GET['tanggal_selesai'] : '';
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

// Query default tanpa filter
$query = "SELECT peminjaman.*, users.nama, buku.judul 
          FROM peminjaman 
          JOIN users ON peminjaman.user_id = users.id 
          JOIN buku ON peminjaman.buku_id = buku.id ";

// Jika filter tanggal digunakan
if (!empty($tanggal_mulai) && !empty($tanggal_selesai)) {
    $query .= " WHERE peminjaman.tanggal_pinjam BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'";
}

// Jika pencarian nama atau judul buku digunakan
if (!empty($cari)) {
    $query .= " AND (users.nama LIKE '%$cari%' OR buku.judul LIKE '%$cari%')";
}

$query .= " ORDER BY peminjaman.tanggal_pinjam DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman</title>
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
        <h2>Laporan Peminjaman Buku</h2>

        <!-- Form Filter Tanggal dan Cari -->
        <form method="GET" action="" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <label for="tanggal_mulai">Dari Tanggal:</label>
                    <input type="date" name="tanggal_mulai" value="<?= $tanggal_mulai ?>" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="tanggal_selesai">Sampai Tanggal:</label>
                    <input type="date" name="tanggal_selesai" value="<?= $tanggal_selesai ?>" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="cari">Cari:</label>
                    <input type="text" name="cari" value="<?= $cari ?>" class="form-control" placeholder="Cari Nama Anggota atau Judul Buku">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Filter</button>
            <a href="tambah_peminjaman.php" class="btn btn-success mt-3 ml-2">Tambah Peminjaman</a>
        </form>

        <table class="table table-bordered">
            <thead>
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
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['judul'] ?></td>
                        <td><?= $row['tanggal_pinjam'] ?></td>
                        <td><?= $row['tanggal_kembali'] ? $row['tanggal_kembali'] : '-' ?></td>
                        <td><?= ucfirst($row['status']) ?></td>
                        <td>
                            <a href="edit_peminjaman.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus_peminjaman.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus peminjaman ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <br>
        <a href="dashboard_admin.php" class="btn btn-secondary">Kembali ke Dashboard Admin</a> | 
        <a href="cetak_laporan.php?tanggal_mulai=<?= $tanggal_mulai ?>&tanggal_selesai=<?= $tanggal_selesai ?>" class="btn btn-info" target="_blank">Cetak Laporan</a>
    </div>
</body>
</html>
