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
