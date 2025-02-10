<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'datapasien_db';

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Logika untuk memproses data login
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Filter input untuk keamanan
    $username = htmlspecialchars(trim($_POST['username']));
    $password = trim($_POST['password']);

    // Query untuk memeriksa username dan password
    $sql = "SELECT * FROM admin WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Simpan informasi ke session
        $_SESSION['username'] = $user['username'];

        // Redirect ke dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        echo "<script>alert('Username atau password salah! Silakan coba lagi.');</script>";
    }

    $stmt->close();
}

$conn->close();
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
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" placeholder="Masukkan username" maxlength="50" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Masukkan password" maxlength="50" required>
            
            <button type="submit">Login</button>
        </form>
    </div>
    <div class="footer">
        <p>&copy; 2025 qolbiyahh. All rights reserved.</p>
    </div>
</body>
</html>
