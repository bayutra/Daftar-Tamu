<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jumlah_uang = $_POST['jumlah_uang'];
    $checked = isset($_POST['checked']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO data (nama, alamat, jumlah_uang, checked) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $nama, $alamat, $jumlah_uang, $checked);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Error menambahkan data: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Baru</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <div class="container">
        <h2>Tambah Data Baru</h2>
        <form method="post">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required><br>

            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat" required></textarea><br>

            <label for="jumlah_uang">Jumlah Uang:</label>
            <input type="number" id="jumlah_uang" name="jumlah_uang" step="0.01" required><br>

            <label for="checked">Checked:</label>
            <input type="checkbox" id="checked" name="checked"><br>

            <button type="submit">Tambah Data</button>
        </form>
        <a href="dashboard.php">Kembali ke Dashboard</a>
    </div>
</body>
</html>