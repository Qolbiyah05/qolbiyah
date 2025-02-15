<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil data anggota berdasarkan ID dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $anggota = $result->fetch_assoc();

    if (!$anggota) {
        echo "<script>alert('Data tidak ditemukan!'); window.location='kelola_anggota.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID tidak valid!'); window.location='kelola_anggota.php';</script>";
    exit();
}

// Proses update data anggota
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($password)) {
        // Update dengan password baru
        $query = "UPDATE users SET nama=?, jurusan=?, email=?, password=? WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $nama, $jurusan, $email, $password, $id);
    } else {
        // Update tanpa mengubah password
        $query = "UPDATE users SET nama=?, jurusan=?, email=? WHERE id=?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("sssi", $nama, $jurusan, $email, $id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Data anggota berhasil diperbarui!'); window.location='kelola_anggota.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!'); window.location='edit_anggota.php?id=$id';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota</title>
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

    <!-- Form Edit Anggota -->
    <div class="container mt-5">
        <h2>Edit Anggota</h2>

        <form action="edit_anggota.php?id=<?= $anggota['id'] ?>" method="POST">
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control" id="nim" name="nim" value="<?= htmlspecialchars($anggota['nim']) ?>" required disabled>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($anggota['nama']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="jurusan" class="form-label">Jurusan</label>
                <input type="text" class="form-control" id="jurusan" name="jurusan" value="<?= htmlspecialchars($anggota['jurusan']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($anggota['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password Baru (kosongkan jika tidak ingin mengubah)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <button type="submit" class="btn btn-primary">Update Anggota</button>
            <a href="kelola_anggota.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
