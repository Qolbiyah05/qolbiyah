<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$foto = ''; // Variabel untuk menyimpan path foto

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = htmlspecialchars($_POST['judul']);
    $penulis = htmlspecialchars($_POST['penulis']);
    $penerbit = htmlspecialchars($_POST['penerbit']);
    $tahun_terbit = intval($_POST['tahun_terbit']);
    $jumlah = intval($_POST['jumlah']);
    $tersedia = $jumlah; // Default jumlah tersedia sama dengan jumlah buku

    // Proses upload foto
    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "uploads/"; // Folder penyimpanan gambar
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Buat folder jika belum ada
        }

        $file_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        // Nama file unik
        $foto_name = "buku_" . time() . "." . $file_extension;
        $foto_path = $target_dir . $foto_name;

        // Validasi jenis file
        if (in_array($file_extension, $allowed_types)) {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $foto_path)) {
                $foto = basename($foto_path); // Simpan hanya nama file di database
            } else {
                echo "<script>alert('Gagal mengunggah gambar.'location : kelola_buku.php );</script>";
            }
        } else {
            echo "<script>alert('Format gambar tidak valid! Hanya JPG, JPEG, PNG, dan GIF yang diperbolehkan.');</script>";
        }
    }

    // Simpan data ke database dengan prepared statement
    $query = "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, jumlah, tersedia, foto) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssiiis", $judul, $penulis, $penerbit, $tahun_terbit, $jumlah, $tersedia, $foto);

    if ($stmt->execute()) {
        echo "<script>alert('Buku berhasil ditambahkan!'); window.location='kelola_buku.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan buku: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
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
        .book-image {
            max-width: 100%;
            height: auto;
            margin-top: 20px;
            display: block;
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

    <!-- Konten Utama -->
    <div class="main-content">
        <div class="container mt-5">
            <div class="card">
                <h2 class="mb-4">Tambah Buku Baru</h2>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Judul Buku:</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Penulis:</label>
                        <input type="text" name="penulis" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Penerbit:</label>
                        <input type="text" name="penerbit" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tahun Terbit:</label>
                        <input type="number" name="tahun_terbit" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah:</label>
                        <input type="number" name="jumlah" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto Buku:</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Buku</button>
                    <a href="kelola_buku.php" class="btn btn-secondary">Batal</a>
                </form>

                <!-- Tampilkan foto buku setelah ditambahkan -->
                <?php if (!empty($foto)): ?>
                    <img src="uploads/<?php echo $foto; ?>" alt="Foto Buku" class="book-image">
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
