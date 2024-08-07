<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM data WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Error menghapus data: " . $conn->error;
    }
    $stmt->close();
} else {
    header("Location: dashboard.php");
}

$conn->close();
?>