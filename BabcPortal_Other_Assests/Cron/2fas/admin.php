<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $email = $_POST['email'];
    $enable_2fa = isset($_POST['enable_2fa']) ? 1 : 0;
    $mail2fa = isset($_POST['mail2fa']) ? 1 : 0;

    $conn->query("INSERT INTO users (username, password, email, role, enable_2fa, mail2fa) VALUES ('$username', '$password', '$email', 'user', '$enable_2fa', '$mail2fa')");
    $success = "User created successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1>Create User</h1>
                <?php if (isset($success)) echo "<p class='text-success'>$success</p>"; ?>
                <form method="post" action="admin.php">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="enable_2fa" name="enable_2fa">
                        <label class="form-check-label" for="enable_2fa">Enable 2FA App</label>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="mail2fa" name="mail2fa">
                        <label class="form-check-label" for="mail2fa">Enable Mail 2FA</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </form>
                <p><a href="logout.php">Logout</a></p>
            </div>
        </div>
    </div>
</body>
</html>