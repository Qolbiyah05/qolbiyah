<?php
// Membuat koneksi ke database
$conn = new mysqli("localhost", "root", "", "datapasien_db");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah parameter `id` dan `jenis` diterima
if (!isset($_GET['id']) || !isset($_GET['jenis'])) {
    echo "<script>
            alert('Parameter tidak lengkap. Format URL yang benar: delete.php?id=1&jenis=BPJS atau delete.php?id=2&jenis=Non-BPJS');
            window.history.back();
          </script>";
    exit();
}

// Ambil parameter
$id = $conn->real_escape_string($_GET['id']);
$jenis = $conn->real_escape_string($_GET['jenis']); // BPJS atau Non-BPJS

// Tentukan tabel berdasarkan jenis
if ($jenis === "BPJS") {
    $sql = "DELETE FROM pasien WHERE id = $id";
} elseif ($jenis === "Non-BPJS") {
    $sql = "DELETE FROM `pasien_non-bpjs` WHERE id = $id";
} else {
    echo "<script>
            alert('Jenis pasien tidak valid.');
            window.history.back();
          </script>";
    exit();
}

// Eksekusi query untuk menghapus data
if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('Data berhasil dihapus');
            window.location='pasien_" . strtolower($jenis) . ".php';
          </script>";
} else {
    echo "Error: " . $conn->error;
}
?>
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
// Tutup koneksi
$conn->close();
?>
