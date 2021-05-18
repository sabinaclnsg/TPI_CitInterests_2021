<?php
require_once 'controllers/login_controller.php';
?>
<!DOCTYPE html>
<html>

<head>
    <?php require_once 'controllers/head.php' // -- head -- 
    ?>
    <!-- Google Captcha -->
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body style="background: url(&quot;assets/img/other/image-login.jpg&quot;);background-size: cover;">

    <?php
    require_once 'controllers/navbar_top.php';
    ?>

    <div class="container" id="main-content" style="height: 100%">
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
                                <div class="flex-grow-1 bg-register-image" style="background: url(&quot;assets/img/other/image-login.jpg&quot;);background-size: cover;"></div>
                            </div>
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">Connexion</h4>
                                    </div>
                                    <form class="user" action="index.php?page=login" method="POST">
                                        <div class="form-group"><input class="form-control form-control-user" type="email" id="EmailLoginInput" aria-describedby="emailHelp" placeholder="Adresse e-mail" name="email" style="border-radius: .35rem;"></div>
                                        <div class="form-group"><input class="form-control form-control-user" type="password" id="PasswordLoginInput" placeholder="Mot de passe" name="password" style="border-radius: .35rem;"></div>
                                        <!-- Google Captcha -->
                                        <div class="g-recaptcha" data-sitekey="6Lc-Rs0aAAAAAMrPSbrIt2atdsc3w2pTSsho1Ukc"></div>

                                        <button class="btn btn-yellow btn-block btn-user" type="submit" name="submit" style="border-radius: .35rem;">Se connecter</button>

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
    <?php include_once 'controllers/footer.php' ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>

    <script src="assets/js/alert-timeout.js"></script>
</body>

</html>