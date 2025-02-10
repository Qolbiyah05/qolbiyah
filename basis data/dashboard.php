<?php
session_start(); // Memulai session

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum login, redirect ke halaman login
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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

    <!-- Main Content -->
    <div class="main-content">
        <div class="container mt-4">
            <h1>Welcome to Data Rumah Sakit Bangsa</h1>
            <p>Hai, <?= htmlspecialchars($_SESSION['username']); ?>! Anda berhasil login.</p>

            <div class="row">
                <!-- Card Pasien BPJS -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Data Pasien BPJS:</div>
                            <div class="text-lg mb-0 font-weight-bold text-gray-800">Pasien BPJS</div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small stretched-link" href="pasien_BPJS.php">Lihat Lengkap</a>
                            <div class="small"><i class="fas fa-chevron-right"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Card Pasien Non-BPJS -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Data Pasien Non-BPJS:</div>
                            <div class="text-lg mb-0 font-weight-bold text-gray-800">Pasien Non-BPJS</div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small stretched-link" href="pasien_non-BPJS.php">Lihat Lengkap</a>
                            <div class="small"><i class="fas fa-chevron-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <h6 class="text-center">Jln. Siliwangi No.9 Kota Bekasi</h6>
        </div>

        <footer class="text-center py-3 bg-light border-top">
            <p>&copy; 2025 Qolbyyyh. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
