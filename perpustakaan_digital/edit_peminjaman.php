<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Mengambil ID peminjaman dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data peminjaman yang akan diedit
    $query = "SELECT * FROM peminjaman WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Peminjaman tidak ditemukan.";
        exit();
    }
}

// Proses update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $status = $_POST['status'];

    $updateQuery = "UPDATE peminjaman SET tanggal_kembali = ?, status = ? WHERE id = ?";
    $updateStmt = $koneksi->prepare($updateQuery);
    $updateStmt->bind_param('ssi', $tanggal_kembali, $status, $id);

    if ($updateStmt->execute()) {
        header("Location: kelola_peminjaman.php?message=update_success");
        exit();
    } else {
        echo "Gagal memperbarui data peminjaman.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peminjaman</title>
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
        <h2>Edit Peminjaman</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" value="<?= htmlspecialchars($row['tanggal_kembali']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="pinjam" <?= $row['status'] == 'pinjam' ? 'selected' : '' ?>>Pinjam</option>
                    <option value="kembali" <?= $row['status'] == 'kembali' ? 'selected' : '' ?>>Kembali</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="kelola_peminjaman.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
