<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = $_POST['code'];

    require_once 'vendor/autoload.php';
    $tfa = new RobThree\Auth\TwoFactorAuth('Babc Portal');
    $isCodeValid = $tfa->verifyCode($_SESSION['secret_key'], $code);

    if (!$isCodeValid) {
        $error = 'Invalid 2FA code';
    } else {
        if ($_SESSION['role'] == 'admin') {
            header('Location: admin.php');
        } else {
            header('Location: dashboard.php');
        }
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify 2FA</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1>Verify 2FA Code</h1>
                <form method="post" action="verify_2fa.php">
                    <div class="form-group">
                        <label for="code">Enter 2FA Code</label>
                        <label for="code">Enter 2FA Code</label>
                        <input type="text" class="form-control" id="code" name="code" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Verify</button>
                </form>
                <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
            </div>
        </div>
    </div>
</body>
</html>