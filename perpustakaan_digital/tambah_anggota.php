<?php
include 'koneksi.php'; // Pastikan koneksi dimuat
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Ambil password dari input

    // Validasi password agar tidak kosong
    if (empty($password)) {
        echo "<script>alert('Password tidak boleh kosong!'); window.location='tambah_anggota.php';</script>";
        exit();
    }

    // Cek apakah email sudah ada di database
    $cek_email = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $cek_email->bind_param("s", $email);
    $cek_email->execute();
    $cek_email->store_result();

    if ($cek_email->num_rows > 0) {
        echo "<script>alert('Email sudah digunakan, silakan gunakan email lain!'); window.location='tambah_anggota.php';</script>";
        exit();
    }
    $cek_email->close();

    // Insert data anggota baru ke database
    $query = "INSERT INTO users (nim, nama, jurusan, email, password, role) VALUES (?, ?, ?, ?, ?, 'anggota')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssss', $nim, $nama, $jurusan, $email, $password);

    if ($stmt->execute()) {
        echo "<script>
            alert('Anggota berhasil ditambahkan!\\nEmail: $email\\nPassword: $password');
            window.location='kelola_anggota.php';
        </script>";
    } else {
        echo "<script>alert('Gagal menambahkan anggota!'); window.location='tambah_anggota.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anggota</title>
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

    <div class="container mt-5">
        <h2>Tambah Anggota</h2>

        <form action="tambah_anggota.php" method="POST">
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control" id="nim" name="nim" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="jurusan" class="form-label">Jurusan</label>
                <input type="text" class="form-control" id="jurusan" name="jurusan" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Anggota</button>
            <a href="kelola_anggota.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
