<?php
include 'config.php';

$message = "";

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid Post ID");
}

$id = (int)$_GET['id'];

// Fetch post using prepared statement
$sql = "SELECT * FROM posts WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$row) {
    die("Post not found.");
}

// Update post
if (isset($_POST['update'])) {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Server-side validation
    if (strlen($title) < 3) {

        $message = "Post title must be at least 3 characters long.";

    } elseif (strlen($content) < 10) {

        $message = "Post content must be at least 10 characters long.";

    } else {

        $updateSql = "UPDATE posts SET title = ?, content = ? WHERE id = ?";

        $updateStmt = mysqli_prepare($conn, $updateSql);

        mysqli_stmt_bind_param(
            $updateStmt,
            "ssi",
            $title,
            $content,
            $id
        );

        if (mysqli_stmt_execute($updateStmt)) {

            mysqli_stmt_close($updateStmt);

            header("Location: index.php");
            exit();

        } else {

            $message = "Failed to update post.";

        }

        mysqli_stmt_close($updateStmt);
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

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow">

                <div class="card-body">

                    <h2 class="text-center mb-4">
                        Edit Post
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
                                value="<?php echo htmlspecialchars($row['title']); ?>"
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
                                minlength="10"
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