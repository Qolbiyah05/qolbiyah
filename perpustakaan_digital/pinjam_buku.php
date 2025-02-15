<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'anggota') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$pesan = "";

// Cek jumlah buku yang sedang dipinjam oleh anggota ini
$cek_pinjaman_query = "SELECT COUNT(*) as jumlah FROM peminjaman WHERE user_id = '$user_id' AND status = 'dipinjam'";
$cek_pinjaman_result = $conn->query($cek_pinjaman_query);
$cek_pinjaman_data = $cek_pinjaman_result->fetch_assoc();

if ($cek_pinjaman_data['jumlah'] >= 3) {
    $pesan = "<div class='alert alert-warning text-center'>Anda sudah mencapai batas maksimal peminjaman (3 buku).<br>
              <a href='daftar_pinjaman.php' class='btn btn-primary mt-2'>Lihat Daftar Peminjaman</a></div>";
}

// Ambil daftar buku yang tersedia
$buku_query = "SELECT * FROM buku WHERE tersedia > 0";
$buku_result = $conn->query($buku_query);

if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($pesan)) {
    $buku_id = $_POST['buku_id'];
    $tanggal_pinjam = date('Y-m-d');
    $tanggal_kembali = date('Y-m-d', strtotime("+7 days"));

    // Simpan data peminjaman
    $query = "INSERT INTO peminjaman (user_id, buku_id, tanggal_pinjam, tanggal_kembali, status) 
              VALUES ('$user_id', '$buku_id', '$tanggal_pinjam', '$tanggal_kembali', 'dipinjam')";

    if ($conn->query($query) === TRUE) {
        // Kurangi jumlah buku yang tersedia
        $update_buku = "UPDATE buku SET tersedia = tersedia - 1 WHERE id = '$buku_id'";
        $conn->query($update_buku);

        // Notifikasi sukses
        $pesan = "<div class='alert alert-success alert-dismissible fade show text-center' role='alert'>
                    <strong>Buku berhasil dipinjam!</strong> Silakan cek <a href='daftar_pinjaman.php' class='alert-link'>daftar peminjaman</a>.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
    } else {
        $pesan = "<div class='alert alert-danger text-center'>Terjadi kesalahan: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Buku</title>
    
    <!-- Bootstrap CSS -->
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
            margin-bottom: 10px;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            flex: 1;
            padding: 20px;
        }
        .card {
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .book-image {
            display: block;
            max-width: 200px;
            margin: 10px auto;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        footer {
            text-align: center;
            padding: 10px;
            background: #e9ecef;
            border-top: 1px solid #ddd;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center">ANGGOTA</h4>
        <nav>
            <a href="dashboard_anggota.php"><i class="fas fa-home me-2"></i> Beranda</a>
            <a href="daftar_pinjaman.php"><i class="fas fa-book me-2"></i> Buku Dipinjam</a>
            <a href="histori_peminjaman.php"><i class="fas fa-history me-2"></i> Histori Peminjaman</a>
            <div class="dropdown-divider"></div>
            <a href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Keluar</a>
        </nav>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="container mt-4">
            <h2 class="mb-4">Form Peminjaman Buku</h2>
            
            <!-- Notifikasi -->
            <?= $pesan; ?>
            
            <div class="card p-4">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label">Pilih Buku:</label>
                        <select name="buku_id" id="bukuSelect" class="form-select" required>
                            <option value="">Pilih Buku</option>
                            <?php 
                            $buku_result->data_seek(0); // Reset pointer hasil query
                            while ($buku = $buku_result->fetch_assoc()) { 
                                echo "<option value='{$buku['id']}' data-foto='{$buku['foto']}'>" . 
                                     htmlspecialchars($buku['judul']) . " - (Tersedia: {$buku['tersedia']})</option>";
                            } 
                            ?>
                        </select>
                    </div>
                    <div class="text-center">
                        <img id="bukuImage" class="book-image" src="" alt="Gambar Buku" style="display:none;">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Pinjam Buku</button>
                </form>
            </div>
            <a href="dashboard_anggota.php" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
        </div>
    </div>
    
    <footer>
        <p>&copy; 2025 Perpustakaan Qolbyhh.</p>
    </footer>

    <!-- JavaScript untuk menampilkan gambar buku -->
    <script>
        document.getElementById('bukuSelect').addEventListener('change', function() {
            let selectedOption = this.options[this.selectedIndex];
            let fotoPath = selectedOption.getAttribute('data-foto');
            let bukuImage = document.getElementById('bukuImage');
            
            if (fotoPath) {
                bukuImage.src = 'uploads/' + fotoPath; // Sesuaikan dengan folder penyimpanan foto buku
                bukuImage.style.display = 'block';
            } else {
                bukuImage.style.display = 'none';
            }
        });
    </script>
</body>
</html>
