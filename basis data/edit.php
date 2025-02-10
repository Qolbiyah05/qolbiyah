<?php
// Membuat koneksi ke database
$conn = new mysqli("localhost", "root", "", "datapasien_db");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Jika ID pasien ada, ambil data pasien
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data pasien berdasarkan ID
    $sql = "SELECT * FROM pasien WHERE id = $id";
    $result = $conn->query($sql);

    // Cek apakah ada data pasien
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data pasien tidak ditemukan.";
        exit();
    }
}

// Proses pengeditan data jika form disubmit
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $no_bpjs = $_POST['no_bpjs'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $nik = $_POST['nik'];
    $alamat = $_POST['alamat'];

    // Update data pasien
    $update_sql = "UPDATE pasien SET 
                   nama = '$nama',
                   no_bpjs = '$no_bpjs',
                   tgl_lahir = '$tgl_lahir',
                   nik = '$nik',
                   alamat = '$alamat'
                   WHERE id = $id";

    if ($conn->query($update_sql) === TRUE) {
        echo "Data berhasil diedit";
        header("Location: pasien_bpjs.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pasien BPJS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
<style>
        body {
            background-color: #f8f9fa; /* Background color */
            color: #212529; /* Text color */
            display: flex;
            min-height: 100vh;
            margin: 0;
        }

        .sidebar {
            width: 250px;
            background-color: #000; /* Red color */
            color: #fff;
            min-height: 100vh;
        }

        .sidebar .nav-item.active {
            background-color: gray;
        }

        .sidebar a {
            text-decoration: none;
            color: white;
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }

        .card {
            background-color: #f8f9fa; /* Light background for cards */
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
    <div class="sidebar p-4">
        <div class="text-2xl font-bold mb-3">ADMIN</div>
        <nav>
            <a class="btn btn-grey w-100 d-flex align-items-center py-2 px-4 mb-2" href="dashboard.php">
                <i class="fas fa-tachometer-alt me-3"></i>
                Beranda
            </a>
            <a class="btn btn-grey w-100 d-flex align-items-center py-2 px-4 mb-2" href="dokter.php">
                <i class="fas fa-user-md me-3"></i>
                Dokter
            </a>
            <a class="btn btn-grey w-100 d-flex align-items-center py-2 px-4 mb-2" href="staff_kantor.php">
                <i class="fas fa-user-tie me-3"></i>
                Staff Kantor
            </a>
            <a class="btn btn-grey w-100 d-flex align-items-center py-2 px-4 mb-2" href="pasien_bpjs.php">
                <i class="fas fa-users me-3"></i>
                Pasien BPJS
            </a>
            <a class="btn btn-grey w-100 d-flex align-items-center py-2 px-4 mb-2" href="pasien_non-bpjs.php">
                <i class="fas fa-user-check me-3"></i>
                Pasien Non-BPJS
            </a>
            <div class="dropdown-divider my-2"></div>
            <a class="btn btn-grey w-100 d-flex align-items-center py-2 px-4" href="logout.php">
                <i class="fas fa-sign-out-alt me-3"></i>
                Keluar
            </a>
        </nav>
    </div>
    <div class="container mt-5">
        <h1>Edit Data Pasien BPJS</h1>

        <form method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($row['nama']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="no_bpjs" class="form-label">No. BPJS</label>
                <input type="text" class="form-control" id="no_bpjs" name="no_bpjs" value="<?php echo htmlspecialchars($row['no_bpjs']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?php echo htmlspecialchars($row['tgl_lahir']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control" id="nik" name="nik" value="<?php echo htmlspecialchars($row['nik']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" required><?php echo htmlspecialchars($row['alamat']); ?></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
