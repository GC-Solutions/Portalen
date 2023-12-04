<?php
session_start();
require_once 'config.php';
require_once 'vendor/autoload.php';

use Endroid\QrCode\QrCode;

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$tfa = new RobThree\Auth\TwoFactorAuth('Babc Portal');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isCodeValid = $tfa->verifyCode($_SESSION['temp_secret'], $_POST['code']);
    if ($isCodeValid) {
        $secret = $_SESSION['temp_secret'];
        $conn->query("UPDATE users SET secret_key = '$secret' WHERE id = " . $_SESSION['user_id']);
        unset($_SESSION['temp_secret']);
        header('Location: logout.php');
        exit;
    } else {
        $error = 'Invalid 2FA code';
    }
}

if (!isset($_SESSION['temp_secret'])) {
    $_SESSION['temp_secret'] = $tfa->createSecret();
}
$secret = $_SESSION['temp_secret'];
$qrCodeUrl = $tfa->getQRCodeImageAsDataUri($_SESSION['username'], $secret);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set up 2FA</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1>Set up Two Factor Authentication</h1>
                <p>Scan the QR code with your 2FA app:</p>
                <img src="<?php echo $qrCodeUrl; ?>" alt="QR Code">
                <form method="post" action="setup_2fa.php" class="mt-4">
                    <div class="form-group">
                        <label for="code">Enter 2FA Code</label>
                        <input type="text" class="form-control" id="code" name="code" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Verify</button>
                </form>
                <form method="post" action="logout.php" class="mt-4">
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
                <?php if (isset($error)) echo "<p class='text-danger mt-3'>$error</p>"; ?>
            </div>
        </div>
    </div>
</body>
</html>