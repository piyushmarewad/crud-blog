<?php
include 'config.php';

$message = "";

if(isset($_POST['register'])){

    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query(
        $conn,
        "SELECT * FROM users WHERE username='$username'"
    );

    if(mysqli_num_rows($check) > 0){

        $message = "Username already exists!";

    } else {

        $sql = "INSERT INTO users(username, password)
                VALUES('$username','$password')";

        if(mysqli_query($conn, $sql)){
            $message = "Registration Successful!";
        } else {
            $message = "Registration Failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card mt-5">

                <div class="card-body">

                    <h2 class="text-center mb-4">
                        User Registration
                    </h2>

                    <?php
                    if(!empty($message)){
                    ?>

                        <div class="alert alert-info">
                            <?php echo $message; ?>
                        </div>

                    <?php
                    }
                    ?>

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