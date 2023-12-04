<?php include_once dirname(__DIR__) .'/layout/Login_Page/header.php'; ?>

<header>
  <div class="overlay"></div>
  
    <div class="container-login100 page-background">

        <div class="wrap-logo">
            <div class="blur-circle">
                <div class="blur-circle-wrapper">
                  <h1 id="logo-h1">Babc</h1>
                  <h2 id="logo-h2">Portal</h2>
                  <p id="logo-p">Bace for Analyse, Building solutions<br>& Control your buisness</p>
                </div>
            </div>
        </div>
        
        <div class="wrap-login100">
            
             <form class="login100-form validate-form" method="post" action="<?php echo baseUrl;?>login">
             
                <h1 class="signIn-h1" >Sign in</h1>
                <p class="signIn-p" >Sign in to manage your account</p>

                <span class="login100-form-title p-b-34 p-t-27">
                
                    <!-- <img src="assets/images/Logo/Default/BABCvit.png" alt="" width="300" height="153"> -->

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
                    <input class="input100" type="email" name="username" required placeholder="Email">
                    <span class="focus-input100" data-placeholder="&#xf207;"></span>
                </div>
                <div class="wrap-input100 validate-input" data-validate="Enter password">
                    <input class="input100" type="password" required name="password" placeholder="Password">
                    <span class="focus-input100" data-placeholder="&#xf191;"></span>
                </div>
       
                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" type="submit">
                        Log In
                    </button>
                </div>

                <div class="footer-wrapper">
                  <h1 id="footer-logo-h1">Babc</h1>
                  <h2 id="footer-logo-h2">Portal</h2>
                  <p id="footer-logo-p">Bace for Analyse, Building solutions<br>& Control your buisness</p>
                </div>
            </form>
        </div>
    </div>
</header>

<?php include_once dirname(__DIR__) . '/layout/Login_Page/footer.php'; ?>
