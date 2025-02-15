<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'petugas') {
    header("Location: login.php");
    exit();
}

// Periksa apakah ID buku dikirimkan
if (!isset($_GET['id'])) {
    header("Location: kelola_bukupetugas.php");
    exit();
}

$id = intval($_GET['id']);
$query = "SELECT * FROM buku WHERE id = $id";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    echo "<script>alert('Buku tidak ditemukan!'); window.location='kelola_bukupetugas.php';</script>";
    exit();
}

$buku = $result->fetch_assoc();
$fotoLama = $buku['foto'];

// Proses update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = htmlspecialchars($_POST['judul']);
    $penulis = htmlspecialchars($_POST['penulis']);
    $tersedia = intval($_POST['tersedia']);

    // Cek jika ada unggahan foto baru
    if ($_FILES['foto']['name']) {
        $fotoBaru = $_FILES['foto']['name'];
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($fotoBaru);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Validasi ekstensi file
        if (!in_array($imageFileType, $validExtensions)) {
            echo "<script>alert('Format gambar harus JPG, JPEG, PNG, atau GIF!');</script>";
        } else {
            // Hapus foto lama jika ada
            if (!empty($fotoLama) && file_exists("uploads/" . $fotoLama)) {
                unlink("uploads/" . $fotoLama);
            }
            // Pindahkan file baru ke folder uploads
            move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile);
            $fotoLama = $fotoBaru;
        }
    }

    // Update database dengan atau tanpa perubahan foto
    $updateQuery = "UPDATE buku SET judul='$judul', penulis='$penulis', tersedia='$tersedia', foto='$fotoLama' WHERE id=$id";

    if ($conn->query($updateQuery) === TRUE) {
        echo "<script>alert('Data buku berhasil diperbarui!'); window.location='kelola_bukupetugas.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
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
            width: 120px;
            height: 160px;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3>ADMIN</h3>
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="kelola_bukupetugas.php" class="active"><i class="fas fa-book"></i> Kelola Buku</a>
        <a href="kelola_anggota.php"><i class="fas fa-users"></i> Kelola Anggota</a>
        <a href="kelola_peminjaman.php"><i class="fas fa-list"></i> Kelola Peminjaman</a>
        <a href="laporan_peminjaman.php"><i class="fas fa-file-alt"></i> Laporan Peminjaman</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Keluar</a>
    </div>

    <div class="main-content">
        <div class="container mt-5">
            <h2 class="mb-4">Edit Buku</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Judul Buku:</label>
                    <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($buku['judul']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Penulis:</label>
                    <input type="text" name="penulis" class="form-control" value="<?= htmlspecialchars($buku['penulis']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah Tersedia:</label>
                    <input type="number" name="tersedia" class="form-control" value="<?= htmlspecialchars($buku['tersedia']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Foto Saat Ini:</label>
                    <br>
                    <?php if (!empty($buku['foto'])) { ?>
                        <img src="uploads/<?= htmlspecialchars($buku['foto']) ?>" class="book-image">
                    <?php } else { ?>
                        <img src="uploads/default.jpg" class="book-image">
                    <?php } ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Unggah Foto Baru:</label>
                    <input type="file" name="foto" class="form-control">
                    <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="kelola_bukupetugas.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>
