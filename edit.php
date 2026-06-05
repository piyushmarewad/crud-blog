<?php
include 'config.php';

$id = $_GET['id'];

$sql = "SELECT * FROM posts WHERE id=$id";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

$message = "";

if(isset($_POST['update'])){

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    $update = "UPDATE posts
               SET title='$title',
                   content='$content'
               WHERE id=$id";

    if(mysqli_query($conn, $update)){

        header("Location: index.php");
        exit();

    } else {

        $message = "Failed to update post!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Edit Post</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card mt-5">

                <div class="card-body">

                    <h2 class="text-center mb-4">
                        Edit Post
                    </h2>

                    <?php if(!empty($message)){ ?>

                        <div class="alert alert-danger">
                            <?php echo $message; ?>
                        </div>

                    <?php } ?>

                    <form method="POST">

                        <div class="mb-3">

                            <label class="form-label">
                                Post Title
                            </label>

                            <input
                                type="text"
                                name="title"
                                class="form-control"
                                value="<?php echo htmlspecialchars($row['title']); ?>"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Post Content
                            </label>

                            <textarea
                                name="content"
                                class="form-control"
                                rows="6"
                                required
                            ><?php echo htmlspecialchars($row['content']); ?></textarea>

                        </div>

                        <button
                            type="submit"
                            name="update"
                            class="btn btn-warning"
                        >
                            Update Post
                        </button>

                        <a
                            href="index.php"
                            class="btn btn-secondary"
                        >
                            Back to Posts
                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>