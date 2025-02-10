<?php
// Sertakan file koneksi
include 'db.php';

// Ambil parameter pencarian (jika ada)
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk mengambil data dari tabel pasien
$query = "SELECT * FROM pasien_non-bpjs";
if (!empty($search)) {
    $query .= " WHERE nama LIKE '%" . $conn->real_escape_string($search) . "%' 
                OR nik LIKE '%" . $conn->real_escape_string($search) . "%'";
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
    <div class="container mt-5">
        <h1 class="text-center">Data Pasien BPJS</h1>

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
                            <td>" . htmlspecialchars($row['tgl_lahir']) . "</td>
                            <td>" . htmlspecialchars($row['nik']) . "</td>
                            <td>" . htmlspecialchars($row['alamat']) . "</td>
                            <td>
                                <!-- Button Edit -->
                                <a href='edit.php?id=" . urlencode($row['id']) . "' class='btn btn-warning btn-sm'>Edit</a>

                                <!-- Button Delete -->
                                <a href='delete.php?id=" . urlencode($row['id']) . "' class='btn btn-danger btn-sm' 
                                   onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Delete</a>
                            </td>
                        </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>Tidak ada data ditemukan</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
