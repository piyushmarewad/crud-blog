<?php
include 'config.php';

$sql = "SELECT * FROM posts";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)){
?>

<h2><?php echo $row['title']; ?></h2>

<p><?php echo $row['content']; ?></p>

<a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>

<a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>

<hr>

<?php } ?>