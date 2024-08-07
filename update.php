<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jumlah_uang = $_POST['jumlah_uang'];
    $checked = isset($_POST['checked']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE data SET nama = ?, alamat = ?, jumlah_uang = ?, checked = ? WHERE id = ?");
    $stmt->bind_param("ssdii", $nama, $alamat, $jumlah_uang, $checked, $id);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Error mengupdate data: " . $conn->error;
    }
    $stmt->close();
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM data WHERE id = $id");
    $data = $result->fetch_assoc();
} else {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <div class="container">
        <h2>Edit Data</h2>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
            
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required><br>

            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat" required><?php echo htmlspecialchars($data['alamat']); ?></textarea><br>

            <label for="jumlah_uang">Jumlah Uang:</label>
            <input type="number" id="jumlah_uang" name="jumlah_uang" step="0.01" value="<?php echo htmlspecialchars($data['jumlah_uang']); ?>" required><br>

            <label for="checked">Checked:</label>
            <input type="checkbox" id="checked" name="checked" <?php if ($data['checked']) echo "checked"; ?>><br>

            <button type="submit">Update Data</button>
        </form>
        <a href="dashboard.php">Kembali ke Dashboard</a>
    </div>
</body>
</html>