<?php
include 'config.php';

$id = $_GET['id'];

$sql = "DELETE FROM posts WHERE id=$id";

mysqli_query($conn, $sql);

header("Location: index.php");
?>