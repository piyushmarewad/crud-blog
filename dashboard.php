<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
}
?>

<h2>Welcome <?php echo $_SESSION['username']; ?></h2>

<a href="create.php">Create Post</a><br><br>

<a href="index.php">View Posts</a><br><br>

<a href="logout.php">Logout</a>