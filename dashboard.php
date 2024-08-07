<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $data = $conn->query("SELECT * FROM data WHERE nama LIKE '%$search%' OR alamat LIKE '%$search%'");
} else {
    $data = $conn->query("SELECT * FROM data");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Menu Utama</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body> 
    <div class="container">   
        <h2>Selamat datang, <?php echo $_SESSION['username']; ?>!</h2>
        <div class="search-form">
        <form method="get" action="dashboard.php">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
        </div>
        <h3>Data</h3>
        <table border="1">
            <tr>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Jumlah Uang</th>
                <th>Checked</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = $data->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['nama']); ?></td>
                <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                <td><?php echo htmlspecialchars($row['jumlah_uang']); ?></td>
                <td>
                    <input type="checkbox" name="checked[<?php echo $row['id']; ?>]" <?php if ($row['checked']) echo "checked"; ?> onchange="updateChecked(<?php echo $row['id']; ?>, this.checked)">
                </td>
                <td>
                    <a href="update.php?id=<?php echo $row['id']; ?>">Update</a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Anda yakin ingin menghapus data ini?');">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
        <a href="input.php" class="btn add-new-btn">Tambah Data Baru</a>
        <br>
        <a href="logout.php" class="logout-link">Logout</a>
    </div>
    <script>
        function updateChecked(id, isChecked) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_checked.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("id=" + id + "&checked=" + (isChecked ? 1 : 0));
        }
    </script>
</body>
</html>