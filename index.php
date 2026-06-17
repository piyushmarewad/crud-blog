<?php
session_start();
include 'config.php';

$role = isset($_SESSION['role']) ? $_SESSION['role'] : "editor";

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$search = "";

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {

    $search = trim($_GET['search']);
    $searchParam = "%" . $search . "%";

    // Get matching posts
    $sql = "SELECT * FROM posts
            WHERE title LIKE ? OR content LIKE ?
            ORDER BY created_at DESC
            LIMIT ?, ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssii", $searchParam, $searchParam, $start, $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Count matching posts
    $countSql = "SELECT COUNT(*) AS total
                 FROM posts
                 WHERE title LIKE ? OR content LIKE ?";

    $countStmt = mysqli_prepare($conn, $countSql);
    mysqli_stmt_bind_param($countStmt, "ss", $searchParam, $searchParam);
    mysqli_stmt_execute($countStmt);
    $countResult = mysqli_stmt_get_result($countStmt);
    $countRow = mysqli_fetch_assoc($countResult);

} else {

    $sql = "SELECT * FROM posts
            ORDER BY created_at DESC
            LIMIT ?, ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $start, $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $countSql = "SELECT COUNT(*) AS total FROM posts";
    $countResult = mysqli_query($conn, $countSql);
    $countRow = mysqli_fetch_assoc($countResult);
}

$total_posts = $countRow['total'];
$total_pages = ceil($total_posts / $limit);
?>

<!DOCTYPE html>
<html>

<head>
    <title>CRUD Blog</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container mt-4">

    <h1 class="text-center mb-4">CRUD Blog Application</h1>

    <div class="mb-3">
        <a href="create.php" class="btn btn-success">Create New Post</a>
        <a href="dashboard.php" class="btn btn-primary">Dashboard</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <form method="GET" class="mb-4">

        <div class="input-group">

            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search posts..."
                value="<?php echo htmlspecialchars($search); ?>"
            >

            <button class="btn btn-dark" type="submit">
                Search
            </button>

        </div>

    </form>

    <?php if (mysqli_num_rows($result) > 0) { ?>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>

            <div class="card mb-3">

                <div class="card-body">

                    <h3>
                        <?php echo htmlspecialchars($row['title']); ?>
                    </h3>

                    <p>
                        <?php echo nl2br(htmlspecialchars($row['content'])); ?>
                    </p>

                    <small class="text-muted">
                        <?php echo htmlspecialchars($row['created_at']); ?>
                    </small>

                    <br><br>

                    <a
                        href="edit.php?id=<?php echo $row['id']; ?>"
                        class="btn btn-warning"
                    >
                        Edit
                    </a>

                    <?php if ($role == "admin") { ?>

                        <a
                            href="delete.php?id=<?php echo $row['id']; ?>"
                            class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to delete this post?');"
                        >
                            Delete
                        </a>

                    <?php } ?>

                </div>

            </div>

        <?php } ?>

    <?php } else { ?>

        <div class="alert alert-info">
            No posts found.
        </div>

    <?php } ?>

    <nav>

        <ul class="pagination">

            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>

                <li class="page-item">

                    <a
                        class="page-link"
                        href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"
                    >
                        <?php echo $i; ?>
                    </a>

                </li>

            <?php } ?>

        </ul>

    </nav>

</div>

</body>
</html>