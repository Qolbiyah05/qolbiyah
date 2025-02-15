<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil data buku dan anggota
$usersQuery = "SELECT * FROM users WHERE role = 'anggota'";
$usersResult = $conn->query($usersQuery);

$booksQuery = "SELECT * FROM buku";
$booksResult = $conn->query($booksQuery);

// Proses tambah peminjaman
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $buku_id = $_POST['buku_id'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $status = $_POST['status'];

    $query = "INSERT INTO peminjaman (user_id, buku_id, tanggal_pinjam, tanggal_kembali, status) 
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iisss', $user_id, $buku_id, $tanggal_pinjam, $tanggal_kembali, $status);

    if ($stmt->execute()) {
        header("Location: kelola_peminjaman.php?message=add_success");
        exit();
    } else {
        echo "Gagal menambah peminjaman.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            max-width: 600px;
            margin: auto;
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
</head>
<body>
    <div class="container">
        <h2>Tambah Peminjaman</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="user_id" class="form-label">Nama Anggota</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    <?php while ($user = $usersResult->fetch_assoc()) { ?>
                        <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['nama']) ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="buku_id" class="form-label">Judul Buku</label>
                <select class="form-control" id="buku_id" name="buku_id" required>
                    <?php while ($book = $booksResult->fetch_assoc()) { ?>
                        <option value="<?= $book['id'] ?>"><?= htmlspecialchars($book['judul']) ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="pinjam">Pinjam</option>
                    <option value="kembali">Kembali</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Peminjaman</button>
            <a href="kelola_peminjaman.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
