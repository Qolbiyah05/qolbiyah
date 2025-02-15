<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil kata kunci pencarian jika ada
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

// Query untuk mengambil data anggota berdasarkan pencarian
$query = "SELECT id, nim, nama, jurusan, email FROM users WHERE role = 'anggota' AND (nim LIKE ? OR nama LIKE ? OR email LIKE ?)";
$stmt = $conn->prepare($query);
$searchTerm = "%" . $cari . "%"; // Menambahkan wildcard untuk pencarian
$stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            margin: 0;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            padding: 20px;
            height: 100vh;
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
        .table th, .table td {
            vertical-align: middle;
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

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <h2 class="mb-4">Daftar Anggota</h2>

            <!-- Form Pencarian -->
            <form action="kelola_anggota.php" method="get" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" name="cari" placeholder="Cari Anggota" value="<?= htmlspecialchars($cari) ?>">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Cari</button>
                </div>
            </form>

            <!-- Tombol Tambah Anggota -->
            <a href="tambah_anggota.php" class="btn btn-success mb-4">Tambah Anggota</a>

            <!-- Table for Anggota -->
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>Email</th>
                        <th>Password</th> <!-- Kolom password hanya menunjukkan '********' -->
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($anggota = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($anggota['nim']) ?></td>
                            <td><?= htmlspecialchars($anggota['nama']) ?></td>
                            <td><?= htmlspecialchars($anggota['jurusan']) ?></td>
                            <td><?= htmlspecialchars($anggota['email']) ?></td>
                            <td>********</td> <!-- Password disembunyikan -->
                            <td>
                                <!-- Edit Link -->
                                <a href="edit_anggota.php?id=<?= $anggota['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <!-- Reset Password -->
                                <a href="reset_password.php?id=<?= $anggota['id'] ?>" class="btn btn-info btn-sm">Reset Password</a>
                                <!-- Delete Link -->
                                <a href="hapus_anggota.php?id=<?= $anggota['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
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
