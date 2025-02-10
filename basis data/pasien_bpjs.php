<?php
// Sertakan file koneksi
include 'db.php';

// Ambil parameter pencarian (jika ada)
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk mengambil data dari tabel pasien
$query = "SELECT * FROM pasien";
if (!empty($search)) {
    $query .= " WHERE nama LIKE '%" . $conn->real_escape_string($search) . "%' 
                OR no_bpjs LIKE '%" . $conn->real_escape_string($search) . "%'";
}

$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien BPJS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

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
        <h1 class="text-center">Data Pasien BPJS</h1>

        <!-- Tombol Kembali -->
        <a href="dashboard.php" class="btn btn-secondary mb-3">Kembali ke Menu Utama</a>

        <!-- Form Pencarian -->
        <form class="d-flex mb-3" method="GET">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari nama atau no. BPJS" 
                   value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

        <!-- Tombol Tambah Data -->
        <a href="tambah.php" class="btn btn-success mb-3">Tambah Data Pasien</a>

        <!-- Tabel Data -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>No. BPJS</th>
                    <th>Tanggal Lahir</th>
                    <th>NIK</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
if ($result->num_rows > 0) {
    $no = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>" . htmlspecialchars($no) . "</td>
            <td>" . htmlspecialchars($row['nama']) . "</td>
            <td>" . htmlspecialchars($row['no_bpjs']) . "</td>
            <td>" . htmlspecialchars($row['tgl_lahir']) . "</td>
            <td>" . htmlspecialchars($row['nik']) . "</td>
            <td>" . htmlspecialchars($row['alamat']) . "</td>
            <td>
                <!-- Button Edit -->
                <a href='edit.php?id=" . urlencode($row['id']) . "' class='btn btn-warning btn-sm'>Edit</a>
                
                <!-- Button Delete -->
                <a href='delete.php?id=" . urlencode($row['id']) . "&jenis=BPJS' class='btn btn-danger btn-sm' 
                   onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Delete</a>
            </td>
        </tr>";
        $no++;
    }
} else {
    echo "<tr><td colspan='7' class='text-center'>Tidak ada data ditemukan</td></tr>";
}
?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
