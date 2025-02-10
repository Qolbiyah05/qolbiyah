<?php
// Sertakan file koneksi
include 'db.php';

// Ambil parameter pencarian (jika ada)
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk mengambil data dari tabel dokter
$query = "SELECT * FROM dokter";
if (!empty($search)) {
    $query .= " WHERE nama LIKE '%" . $conn->real_escape_string($search) . "%' 
                OR kode_dokter LIKE '%" . $conn->real_escape_string($search) . "%'";
}

$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dokter</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Data Dokter</h1>

        <!-- Tombol Kembali -->
        <a href="dashboard.php" class="btn btn-secondary mb-3">Kembali ke Menu Utama</a>

        <!-- Form Pencarian -->
        <form class="d-flex mb-3" method="GET">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari nama atau Kode Dokter" 
                   value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

        <!-- Tombol Tambah Data -->
        <a href="tambahdokter.php" class="btn btn-success mb-3">Tambah Data Dokter</a>

        <!-- Tabel Data -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Dokter</th>
                    <th>Nama</th>
                    <th>Alamat Dokter</th>
                    <th>No.telp</th>
                    <th>Spesialis</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <tbody>
    <?php
    if ($result->num_rows > 0) {
        $no = 1;
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?= htmlspecialchars($no); ?></td>
                <td><?= htmlspecialchars($row['kode_dokter']); ?></td>
                <td><?= htmlspecialchars($row['nama']); ?></td>
                <td><?= htmlspecialchars($row['alamat_dokter']); ?></td>
                <td><?= htmlspecialchars($row['no_telp']); ?></td>
                <td><?= htmlspecialchars($row['spesialis']); ?></td>
                <td>
                    <?php if ($row['foto']): ?>
                        <img src="uploads/<?= htmlspecialchars($row['foto']); ?>" alt="Foto Dokter" style="width: 50px; height: 50px; object-fit: cover;">
                    <?php else: ?>
                        Tidak ada foto
                    <?php endif; ?>
                </td>
                <td>
                    <!-- Button Edit -->
                    <a href="edit.php?id=<?= urlencode($row['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                    
                    <!-- Button Delete -->
                    <a href="delete.php?id=<?= urlencode($row['id']); ?>&jenis=BPJS" class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</a>
                </td>
            </tr>
            <?php
            $no++;
        }
    } else {
        ?>
        <tr>
            <td colspan="7" class="text-center">Tidak ada data ditemukan</td>
        </tr>
        <?php
    }
    ?>
</tbody>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
