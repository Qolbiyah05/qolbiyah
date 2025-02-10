<?php
// Membuat koneksi ke database
$conn = new mysqli("localhost", "root", "", "datapasien_db");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tangani form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil dan validasi input
    $kode_dokter = $_POST['kode_dokter'] ?? null;
    $nama = $_POST['nama'] ?? null;
    $alamat_dokter = $_POST['alamat_dokter'] ?? null;
    $no_telp = $_POST['no_telp'] ?? null;
    $spesialis = $_POST['spesialis'] ?? null;

    $errors = [];

    // Validasi input kosong
    if (empty($kode_dokter)) $errors[] = "Kode Dokter harus diisi.";
    if (empty($nama)) $errors[] = "Nama harus diisi.";
    if (empty($alamat_dokter)) $errors[] = "Alamat Dokter harus diisi.";
    if (empty($spesialis)) $errors[] = "Spesialis harus diisi.";

    // Validasi file upload
    $foto = $_FILES['foto']['name'] ?? null;
    if ($foto) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($_FILES['foto']['tmp_name']);
        if (!in_array($file_type, $allowed_types)) {
            $errors[] = "Format foto tidak valid. Hanya diperbolehkan JPEG, PNG, atau GIF.";
        }
        if ($_FILES['foto']['size'] > 2 * 1024 * 1024) { // Maksimal 2 MB
            $errors[] = "Ukuran foto tidak boleh lebih dari 2MB.";
        }
    } else {
        $errors[] = "Foto harus diunggah.";
    }

    // Jika tidak ada error, proses data
    if (empty($errors)) {
        $uploadDir = 'uploads/';
        $uploadPath = $uploadDir . basename($foto);

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadPath)) {
            // Gunakan prepared statement untuk query
            $stmt = $conn->prepare("INSERT INTO dokter (kode_dokter, nama, alamat_dokter, no_telp, spesialis, foto) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $kode_dokter, $nama, $alamat_dokter, $no_telp, $spesialis, $foto);

            if ($stmt->execute()) {
                header('Location: index.php');
                exit;
            } else {
                echo "Gagal menyimpan data: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Gagal mengunggah foto.";
        }
    } else {
        // Tampilkan semua error
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Dokter</title>
    <style>
    /* Reset margin, padding, and box-sizing */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Body styles */
    body {
        font-family: 'Poppins', Arial, sans-serif;
        background: linear-gradient(to bottom right, #007BFF, #6C63FF);
        color: #333;
        display: auto;
        justify-content: center;
        align-items: center;
        height: 100vh;
        padding: 20px;
    }

    /* Container for the form */
    .form-container {
        background: #fff;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 500px;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .form-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }

    /* Form title */
    h1 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 28px;
        font-weight: bold;
        color: #333;
    }

    /* Form elements */
    label {
        font-weight: bold;
        display: block;
        margin-bottom: 10px;
        color: #555;
    }

    input[type="text"],
    textarea {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: 2px solid #ddd;
        border-radius: 8px;
        font-size: 16px;
        outline: none;
        transition: border-color 0.3s;
    }

    input[type="text"]:focus,
    textarea:focus {
        border-color: #007BFF;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    textarea {
        resize: vertical;
        height: 100px;
    }

    input[type="file"] {
        margin-bottom: 20px;
        font-size: 14px;
    }

    /* Submit button */
    button[type="submit"] {
        background-color: #007BFF;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        width: 100%;
        font-size: 18px;
        font-weight: bold;
        text-transform: uppercase;
        transition: background-color 0.3s, transform 0.2s;
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
        transform: translateY(-3px);
    }

    button[type="submit"]:active {
        transform: translateY(1px);
    }

    /* Back button */
    a.btn-secondary {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 15px;
        text-align: center;
        color: #fff;
        background-color: #6C63FF;
        border-radius: 8px;
        text-decoration: none;
        transition: background-color 0.3s, transform 0.2s;
    }

    a.btn-secondary:hover {
        background-color: #5146d9;
        transform: translateY(-3px);
    }

    a.btn-secondary:active {
        transform: translateY(1px);
    }

</style>

</head>
<body>
<div class="form-container">
        <h1>Tambah Dokter</h1>
        <form action="tambahdokter.php" method="POST" enctype="multipart/form-data">
            <label for="kode_dokter">Kode Dokter:</label>
            <input type="text" id="kode_dokter" name="kode_dokter" required><br>

            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required><br>

            <label for="alamat_dokter">Alamat Dokter:</label>
            <textarea name="alamat_dokter" id="alamat_dokter" required></textarea><br>

            <label for="no_telp">No. Telp:</label>
            <input type="text" id="no_telp" name="no_telp"><br>

            <label for="spesialis">Spesialis:</label>
            <input type="text" id="spesialis" required><br>

            <label for="foto">Foto:</label>
            <input type="file" name="foto" required><br>

            <button type="submit">Simpan</button>
        </form>
        <a href="dashboard.php" class="btn btn-secondary">Kembali ke Menu Utama</a>
    </div>
</body>
</html>