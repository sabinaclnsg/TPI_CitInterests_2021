<?php
require_once 'controllers/login_controller.php';
require_once './forget_password.php';
require_once 'controllers/forget_password_controller.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - CitInterests</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <!-- Google Captcha -->
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <!-- fade animation on load -->
    <link rel="stylesheet" href="assets/css/load-animation.css">
</head>

<body style="background-color: #fff2cc;">
    <?php
    require_once 'controllers/navbar_top.php';
    ?>

    <div class="container" id="main-content">
        <div class="row justify-content-center d-flex h-75 align-items-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <?php
                if (isset($_SESSION['error-message']) && isset($_GET['message'])) {
                    echo $_SESSION['error-message'];
                }
                ?>
                <div class="card shadow o-hidden border-0 my-5 align-self-center">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-5 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-register-image" style="background: url(&quot;assets/img/other/img-login.jpg&quot;);background-size: cover;"></div>
                            </div>
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">Connexion</h4>
                                    </div>
                                    <form class="user" action="index.php?page=login" method="POST">
                                        <div class="form-group"><input class="form-control form-control-user" type="email" id="EmailLoginInput" aria-describedby="emailHelp" placeholder="Adresse e-mail" name="email"></div>
                                        <div class="form-group"><input class="form-control form-control-user" type="password" id="PasswordLoginInput" placeholder="Mot de passe" name="password"></div>
                                        <!-- Google Captcha -->
                                        <div class="g-recaptcha" data-sitekey="6Lc-Rs0aAAAAAMrPSbrIt2atdsc3w2pTSsho1Ukc"></div>

                                        <button class="btn btn-info btn-block text-white btn-user" type="submit" name="submit">Se connecter</button>

                                        <hr>
                                    </form>
                                    <div class="text-center"><a class="small" data-bs-toggle="modal" data-bs-target="#modal-forget-pwd" style="cursor: pointer;">Mot de passe oublié ?</a></div>
                                    <div class="text-center small">Vous n'avez pas de compte ? <u><a class="text-decoration-underline" href="index.php?page=register">Inscription</a></u></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>

    <script src="assets/js/alert-timeout.js"></script>
</body>

</html>