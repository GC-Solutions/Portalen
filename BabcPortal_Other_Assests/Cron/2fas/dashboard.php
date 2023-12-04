<?php

session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SESSION['role'] == 'admin') {
    header('Location: admin.php');
    exit;
}
if ($_SESSION['role'] == 'user') {
    $user_id = $_SESSION['user_id'];
    $user = $conn->query("SELECT * FROM users WHERE id = '$user_id'")->fetch_assoc();
    if ($user['enable_2fa'] == 1 && $user['secret_key'] == null) {
        header('Location: setup_2fa.php');
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
                <p><a href="logout.php">Logout</a></p>
            </div>
        </div>
    </div>
</body>
</html>