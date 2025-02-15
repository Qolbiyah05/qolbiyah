<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $stok = $_POST['stok'];

    $sql = "INSERT INTO books (judul, penulis, penerbit, tahun_terbit, stok) VALUES ('$judul', '$penulis', '$penerbit', '$tahun_terbit', '$stok')";
    $conn->query($sql);
}
?>

<h2>Tambah Buku</h2>
<form method="post">
    Judul: <input type="text" name="judul" required><br>
    Penulis: <input type="text" name="penulis" required><br>
    Penerbit: <input type="text" name="penerbit" required><br>
    Tahun Terbit: <input type="number" name="tahun_terbit" required><br>
    Stok: <input type="number" name="stok" required><br>
    <button type="submit">Tambah</button>
</form>

<h2>Daftar Buku</h2>
<table border="1">
<tr><th>Judul</th><th>Penulis</th><th>Penerbit</th><th>Tahun</th><th>Stok</th></tr>
<?php
$result = $conn->query("SELECT * FROM books");
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['judul']}</td><td>{$row['penulis']}</td><td>{$row['penerbit']}</td><td>{$row['tahun_terbit']}</td><td>{$row['stok']}</td></tr>";
}
?>
</table>
