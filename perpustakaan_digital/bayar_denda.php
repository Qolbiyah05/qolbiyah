<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'anggota') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Hitung total denda
$query = "SELECT SUM(denda) as total_denda FROM peminjaman WHERE user_id = $user_id AND denda > 0";
$result = $koneksi->query($query);
$data = $result->fetch_assoc();
$total_denda = $data['total_denda'];

if (isset($_POST['bayar'])) {
    $query_update = "UPDATE peminjaman SET denda = 0 WHERE user_id = $user_id AND denda > 0";
    if ($koneksi->query($query_update)) {
        echo "Denda telah dibayar!";
        header("Refresh: 2; url=dashboard_anggota.php");
    } else {
        echo "Gagal membayar denda.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Denda</title>
</head>
<body>
    <h2>Pembayaran Denda</h2>
    <p>Total Denda Anda: <strong>Rp <?= number_format($total_denda, 0, ',', '.') ?></strong></p>
    <?php if ($total_denda > 0) { ?>
        <form method="POST">
            <button type="submit" name="bayar">Bayar Sekarang</button>
        </form>
    <?php } else { ?>
        <p>Tidak ada denda yang harus dibayar.</p>
    <?php } ?>
    <a href="dash
