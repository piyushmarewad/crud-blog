<?php
include 'config.php';

$message = "";

if (isset($_POST['submit'])) {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Server-side validation
    if (strlen($title) < 3) {

        $message = "Post title must be at least 3 characters long.";

    } elseif (strlen($content) < 10) {

        $message = "Post content must be at least 10 characters long.";

    } else {

        // Prepared Statement
        $sql = "INSERT INTO posts (title, content) VALUES (?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "ss",
            $title,
            $content
        );

        if (mysqli_stmt_execute($stmt)) {

            mysqli_stmt_close($stmt);

            header("Location: index.php");
            exit();

        } else {

            $message = "Failed to create post.";

        }

        mysqli_stmt_close($stmt);
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

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow">

                <div class="card-body">

                    <h2 class="text-center mb-4">
                        Create New Post
                    </h2>

                    <?php if (!empty($message)) { ?>

                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($message); ?>
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
                                minlength="3"
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
                                minlength="10"
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