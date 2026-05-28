<?php
include 'config.php';

if(isset($_POST['submit'])){

    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "INSERT INTO posts(title, content)
            VALUES('$title','$content')";

    mysqli_query($conn, $sql);

    header("Location: index.php");
}
?>

<form method="POST">

    <input type="text" name="title" placeholder="Title" required><br><br>

    <textarea name="content" placeholder="Content"></textarea><br><br>

    <button type="submit" name="submit">Add Post</button>

</form>