<?php
include 'config.php';

$limit = 5;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$search = "";

if(isset($_GET['search']) && !empty($_GET['search'])){

    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $sql = "SELECT * FROM posts
            WHERE title LIKE '%$search%'
            OR content LIKE '%$search%'
            ORDER BY created_at DESC
            LIMIT $start, $limit";

    $count_sql = "SELECT COUNT(*) AS total
                  FROM posts
                  WHERE title LIKE '%$search%'
                  OR content LIKE '%$search%'";
}
else{

    $sql = "SELECT * FROM posts
            ORDER BY created_at DESC
            LIMIT $start, $limit";

    $count_sql = "SELECT COUNT(*) AS total FROM posts";
}

$result = mysqli_query($conn, $sql);

$count_result = mysqli_query($conn, $count_sql);
$count_row = mysqli_fetch_assoc($count_result);

$total_posts = $count_row['total'];
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

<div class="container">

    <h1 class="mb-4 text-center">CRUD Blog Application</h1>

    <div class="mb-3">
        <a href="create.php" class="btn btn-success">
            Create New Post
        </a>

        <a href="dashboard.php" class="btn btn-primary">
            Dashboard
        </a>
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

    <?php
    if(mysqli_num_rows($result) > 0){

        while($row = mysqli_fetch_assoc($result)){
    ?>

        <div class="card">

            <div class="card-body">

                <h3>
                    <?php echo htmlspecialchars($row['title']); ?>
                </h3>

                <p>
                    <?php echo nl2br(htmlspecialchars($row['content'])); ?>
                </p>

                <small class="text-muted">
                    <?php echo $row['created_at']; ?>
                </small>

                <br><br>

                <a
                    href="edit.php?id=<?php echo $row['id']; ?>"
                    class="btn btn-warning"
                >
                    Edit
                </a>

                <a
                    href="delete.php?id=<?php echo $row['id']; ?>"
                    class="btn btn-danger"
                    onclick="return confirm('Are you sure you want to delete this post?');"
                >
                    Delete
                </a>

            </div>

        </div>

    <?php
        }
    } else {
        echo "<div class='alert alert-info'>No posts found.</div>";
    }
    ?>

    <nav>

        <ul class="pagination">

            <?php
            for($i = 1; $i <= $total_pages; $i++){
            ?>

                <li class="page-item">

                    <a
                        class="page-link"
                        href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"
                    >
                        <?php echo $i; ?>
                    </a>

                </li>

            <?php
            }
            ?>

        </ul>

    </nav>

</div>

</body>

</html>