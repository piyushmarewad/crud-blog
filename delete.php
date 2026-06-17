<?php
session_start();

include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    die("Access Denied! Only administrators can delete posts.");
}

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid Post ID.");
}

$id = (int)$_GET['id'];

// Delete using prepared statement
$sql = "DELETE FROM posts WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {

    mysqli_stmt_close($stmt);

    header("Location: index.php");
    exit();

} else {

    echo "Failed to delete the post.";

    mysqli_stmt_close($stmt);
}
?>