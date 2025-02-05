<?php
include_once('init.php');
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];

    if (RESET_PASSWORD == true) {
        $admin_password = DEFAULT_PASSWORD;
    } else {
        // Validate the password
        $admin_password = Config_All::get_Value('admin_password');
        if (empty($admin_password)) 
        {
            $admin_password = $default_password;
        }
    }
    if (md5($password) === $admin_password) {
        // Password is correct, redirect to the admin page
        $_SESSION['is_admin'] = 1;
        header("Location: result.php");
        exit();
    } else {
        // Password is incorrect, show an error message
        $error = "Incorrect password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mt-5">Admin Login</h1>
                <?php
                if (isset($error)) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
                ?>
                <form action="login.php" method="post" class="mt-4">
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>
    <script src="./js/jquery-3.5.1.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</body>
</html>