<?php
include 'config.php';

$message = "";

if(isset($_POST['submit'])){

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    $sql = "INSERT INTO posts(title, content)
            VALUES('$title','$content')";

    if(mysqli_query($conn, $sql)){

        header("Location: index.php");
        exit();

    } else {

        $message = "Failed to create post!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Create Post</title>

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
                        Create New Post
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
                                placeholder="Enter Post Title"
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
                                placeholder="Enter Post Content"
                                required
                            ></textarea>

                        </div>

                        <button
                            type="submit"
                            name="submit"
                            class="btn btn-success"
                        >
                            Add Post
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