<?php
session_start();
require_once 'config.php';
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$tfa = new RobThree\Auth\TwoFactorAuth('Babc Portal');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['temp_user_id']) && (isset($_POST['code']) || isset($_POST['logout']))) {
        if (isset($_POST['logout'])) {
            header('Location: logout.php');
            exit;
        }

        $user_id = $_SESSION['temp_user_id'];
        $user = $conn->query("SELECT * FROM users WHERE id = '$user_id'")->fetch_assoc();
        if ($user['mail2fa'] == 1) {
            $isCodeValid = $_SESSION['mail_code'] == $_POST['code'];
        } else {
            $isCodeValid = $tfa->verifyCode($user['secret_key'], $_POST['code']);
        }

        if ($isCodeValid) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            unset($_SESSION['temp_user_id'], $_SESSION['attempt'], $_SESSION['mail_code']);
            header('Location: dashboard.php');
            exit;
        } else {
            $_SESSION['attempt'] = isset($_SESSION['attempt']) ? $_SESSION['attempt'] + 1 : 1;
            if ($_SESSION['attempt'] >= 3) {
                header('Location: logout.php');
                exit;
            } else {
                $require_2fa = true;
                $error = 'Invalid 2FA code';
            }
        }
    } else {
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $result = $conn->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (($user['enable_2fa'] == 1 && $user['secret_key'] != null) || $user['mail2fa'] == 1) {
                $_SESSION['temp_user_id'] = $user['id'];
                $require_2fa = true;
                
                if ($user['mail2fa'] == 1) {
                    // Send mail with 2FA code
                    $mail_code = rand(100000, 999999);
                    $_SESSION['mail_code'] = $mail_code;
                    
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host       = $mail_host;
                        $mail->SMTPAuth   = true;
                        $mail->Username   = $mail_username;
                        $mail->Password   = $mail_password;
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port       = $mail_port;

                        $mail->setFrom($mail_username, 'Babc Portal');
                        $mail->addAddress($user['email'], $user['username']);

                        $mail->isHTML(true);
                        $mail->Subject = 'Your 2FA Code';
                        $mail->Body    = "Your 2FA code is: <b>$mail_code</b>";

                        $mail->send();
                    } catch (Exception $e) {
                        $error = "Mailer Error: " . $mail->ErrorInfo;
                    }
                }
            } else {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] == 'user' && $user['enable_2fa'] == 1 && $user['secret_key'] == null) {
                    header('Location: setup_2fa.php');
                } else {
                    header('Location: dashboard.php');
                }
                exit;
            }
        } else {
            $error = 'Invalid username or password';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1>Login</h1>
                <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
                <form method="post" action="login.php">
                    <?php if (!isset($require_2fa)): ?>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    <?php else: ?>
                        <div class="form-group">
                            <label for="code">Enter 2FA Code</label>
                            <input type="text" class="form-control" id="code" name="code" required>
                        </div>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <?php if (isset($require_2fa)): ?>
                        <button type="submit" class="btn btn-danger" name="logout">Logout</button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>