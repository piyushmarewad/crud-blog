<?php
include 'config.php';

$message = "";

if (isset($_POST['register'])) {

    $username = trim($_POST['username']);
    $plainPassword = trim($_POST['password']);

    // Server-side validation
    if (strlen($username) < 3) {
        $message = "Username must be at least 3 characters long.";
    } elseif (strlen($plainPassword) < 6) {
        $message = "Password must be at least 6 characters long.";
    } else {

        // Check if username already exists
        $checkSql = "SELECT id FROM users WHERE username = ?";
        $checkStmt = mysqli_prepare($conn, $checkSql);

        mysqli_stmt_bind_param($checkStmt, "s", $username);
        mysqli_stmt_execute($checkStmt);

        $checkResult = mysqli_stmt_get_result($checkStmt);

        if (mysqli_num_rows($checkResult) > 0) {

            $message = "Username already exists!";

        } else {

            $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

            // Insert new user with default role = editor
            $insertSql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'editor')";
            $insertStmt = mysqli_prepare($conn, $insertSql);

            mysqli_stmt_bind_param(
                $insertStmt,
                "ss",
                $username,
                $hashedPassword
            );

            if (mysqli_stmt_execute($insertStmt)) {
                $message = "Registration Successful! You can now login.";
            } else {
                $message = "Registration Failed!";
            }

            mysqli_stmt_close($insertStmt);
        }

        mysqli_stmt_close($checkStmt);
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>User Registration</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-body">

                    <h2 class="text-center mb-4">
                        User Registration
                    </h2>

                    <?php if (!empty($message)) { ?>

                        <div class="alert alert-info">
                            <?php echo htmlspecialchars($message); ?>
                        </div>

                    <?php } ?>

                    <form method="POST">

                        <div class="mb-3">

                            <label class="form-label">
                                Username
                            </label>

                            <input
                                type="text"
                                name="username"
                                class="form-control"
                                placeholder="Enter Username"
                                minlength="3"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Enter Password"
                                minlength="6"
                                required
                            >

                        </div>

                        <button
                            type="submit"
                            name="register"
                            class="btn btn-success w-100"
                        >
                            Register
                        </button>

                    </form>

                    <div class="text-center mt-3">

                        <a href="login.php">
                            Already have an account? Login
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>