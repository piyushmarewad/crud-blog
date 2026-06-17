<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$role = isset($_SESSION['role']) ? $_SESSION['role'] : "editor";
?>

<!DOCTYPE html>
<html>

<head>

    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-body">

            <h2 class="mb-3">
                Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋
            </h2>

            <h5 class="text-secondary">
                Role: <?php echo htmlspecialchars($role); ?>
            </h5>

            <hr>

            <?php if ($role == "admin") { ?>

                <div class="alert alert-success">
                    <strong>Administrator Access</strong><br>
                    You have full permissions to manage posts and users.
                </div>

            <?php } else { ?>

                <div class="alert alert-info">
                    <strong>Editor Access</strong><br>
                    You can create, view, and edit posts based on your permissions.
                </div>

            <?php } ?>

            <a href="create.php" class="btn btn-success">
                Create Post
            </a>

            <a href="index.php" class="btn btn-primary">
                View Posts
            </a>

            <a href="logout.php" class="btn btn-danger">
                Logout
            </a>

        </div>

    </div>

</div>

</body>

</html>