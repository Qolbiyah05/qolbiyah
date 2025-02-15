<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #eef2f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 350px;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <h4>Registrasi</h4>
        
        <?php
        include 'koneksi.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nim = htmlspecialchars($_POST['nim']);
            $nama = htmlspecialchars($_POST['nama']);
            $jurusan = htmlspecialchars($_POST['jurusan']);
            $email = htmlspecialchars($_POST['email']);
            $password = $_POST['password'];
            $role = $_POST['role'];
            $query = "INSERT INTO users (nim, nama, jurusan, email, password, role) VALUES ('$nim', '$nama', '$jurusan', '$email', '$password', '$role')";
            echo $conn->query($query) === TRUE ? '<div class="alert alert-success">Registrasi berhasil!</div>' : '<div class="alert alert-danger">Error: '. $koneksi->error .'</div>';
        }
        ?>
        
        <form method="POST">
            <input type="text" name="nim" class="form-control mb-2" placeholder="NIM" required>
            <input type="text" name="nama" class="form-control mb-2" placeholder="Nama" required>
            <input type="text" name="jurusan" class="form-control mb-2" placeholder="Jurusan" required>
            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
            <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
            <select name="role" class="form-select mb-3">
                <option value="anggota">Anggota</option>
                <option value="anggota">Petugas</option>
            </select>
            <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </form>
        <a href="login.php" class="d-block mt-3">Sudah punya akun? Login</a>
    </div>
</body>
</html>
