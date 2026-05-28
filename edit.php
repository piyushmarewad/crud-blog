<?php
include 'config.php';

$id = $_GET['id'];

$sql = "SELECT * FROM posts WHERE id=$id";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $title = $_POST['title'];
    $content = $_POST['content'];

    $update = "UPDATE posts
               SET title='$title', content='$content'
               WHERE id=$id";

    mysqli_query($conn, $update);

    header("Location: index.php");
}
?>

<form method="POST">

<input type="text" name="title"
value="<?php echo $row['title']; ?>"><br><br>

<textarea name="content"><?php echo $row['content']; ?></textarea><br><br>

<button type="submit" name="update">Update</button>

</form>