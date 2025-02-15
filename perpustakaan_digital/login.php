<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Cek apakah email ada di database
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) { 
        // Cek apakah password sesuai (karena tidak pakai hash, gunakan perbandingan langsung)
        if ($password === $user['password']) { 
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'];

            // Redirect berdasarkan peran
            switch ($user['role']) {
                case 'admin':
                    header("Location: dashboard_admin.php");
                    break;
                case 'petugas':
                    header("Location: dashboard_petugas.php");
                    break;
                case 'anggota':
                    header("Location: dashboard_anggota.php");
                    break;
                default:
                    header("Location: index.php");
                    break;
            }
            exit();
        } else {
            $_SESSION['error'] = "Password salah!";
        }
    } else {
        $_SESSION['error'] = "Email tidak ditemukan!";
    }

    // Redirect kembali ke login
    header("Location: login.php");
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #eef2f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .header {
            background-color: #007BFF;
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 1.5em;
        }
        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 1em;
        }
        button {
            width: 100%;
            background-color: #007BFF;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #eef2f3;
        min-height: 100vh; /* Minimal tinggi viewport */
        display: flex;
        flex-direction: column; /* Mengatur elemen dalam kolom */
        }

        footer {
        text-align: center;
        font-size: 0.9em;
        color: #888;
        background-color: #f4f4f4; /* Tambahkan latar belakang agar terlihat jelas */
        padding: 10px 0;
        margin-top: auto; /* Pastikan footer selalu berada di bawah */
        }      
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($_SESSION['error'])): ?>
    <p style="color: red;"><?= $_SESSION['error']; ?></p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

        <form action="login.php" method="POST">
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" placeholder="Masukkan email" maxlength="50" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Masukkan password" maxlength="50" required>
            
            <button type="submit">Login</button>
        </form>
        <br>
    <a href="register.php">Belum punya akun? Daftar di sini</a>
    </div>
    <div class="footer">
        <p>&copy; 2025 qolbiyahh.</p>
    </div>
</body>
</html>