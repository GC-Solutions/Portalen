<?php include_once dirname(__DIR__) .'/layout/Login_Page/header.php'; ?>

<header>
  <div class="overlay"></div>
  <!-- <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
    <source src="https://previews.customer.envatousercontent.com/files/09529464-05e5-47ff-b7a1-d3a26e0598fe/video_preview_h264.mp4" type="video/mp4">
</video>-->
  
    <div class="container-login100 page-background">
  <!-- <div class="container-login100 /////// page-background">-->
        <div class="wrap-login100">
             <form class="login100-form validate-form" method="post" action="<?php echo baseUrl;?>login">
                

                <span class="login100-form-title p-b-34 p-t-27">

                    <img src="assets/images/Logo/Default/BABCvit.png" alt="" width="230" height="120">

                    </span>
                    
                <?php if (!empty($successMessage)){ ?>
                    <div class="alert alert-success">
                        <strong>Success!</strong> <?= $successMessage; ?>
                    </div>
                <?php } ?>

                <?php if (!empty($errorMessage)) { ?>
                    <div class="alert alert-danger">
                        <strong>Error!</strong> <?= $errorMessage; ?>
                    </div>
                <?php } ?>

                <div class="wrap-input100 validate-input" data-validate="Enter username">
                    <input class="input100" type="email" name="username" required placeholder="Email Address">
                    <span class="focus-input100" data-placeholder="&#xf207;"></span>
                </div>
                <div class="wrap-input100 validate-input" data-validate="Enter password">
                    <input class="input100" type="password" required name="password" placeholder="Password">
                    <span class="focus-input100" data-placeholder="&#xf191;"></span>
                </div>
               <!-- <div class="contact100-form-checkbox">
                    <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                    <label class="label-checkbox100" for="ckb1">
                        Remember me
                    </label>
                </div>-->
                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" type="submit">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</header>


<?php include_once dirname(__DIR__) . '/layout/Login_Page/footer.php'; ?>
