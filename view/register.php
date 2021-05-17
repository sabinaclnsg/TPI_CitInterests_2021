<?php
require_once './controllers/register_controller.php';
?>
<!DOCTYPE html>
<html>

<head>
    <?php require_once 'controllers/head.php' // -- head -- 
    ?>
    <!-- Google Captcha -->
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body style="background: url(&quot;assets/img/other/image-register.jpg&quot;);background-size: cover;height: 1145px;">
    <?php require_once 'controllers/navbar_top.php' // -- navbar top --  
    ?>

    <div class="container" id="main-content" style="height: 100%">
        <?php
        // display message
        if (isset($_SESSION['error-message']) && isset($_GET['message'])) {
            echo $_SESSION['error-message'];
        }
        ?>
        <div class="card shadow-lg o-hidden border-0 my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-flex">
                        <div class="flex-grow-1 bg-register-image" style="background: url(&quot;assets/img/other/image-register.jpg&quot;);background-size: cover;"></div>
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h4 class="text-dark mb-4">Créer un compte</h4>
                            </div>
                            <form class="user" method="POST" action="index.php?page=register">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="text" id="FirstNameInput" placeholder="Prénom" name="firstname" value="<?= $firstname ?>"></div>
                                    <div class="col-sm-6"><input class="form-control form-control-user" type="text" id="LastNameInput" placeholder="Nom" name="lastname" value="<?= $lastname ?>"></div>
                                </div>
                                <div class="form-group"><input class="form-control form-control-user" type="email" id="EmailInput" aria-describedby="emailHelp" placeholder="Adresse e-mail" name="email" value="<?= $email ?>"></div>
                                <div class="form-group row" id="show_hide_password">
                                    <div class="col-sm-6 mb-3 mb-sm-0 input-group">
                                        <input class="form-control form-control-user" type="password" id="PasswordInput" placeholder="Mot de passe" name="password">
                                        <div class="input-group-append">
                                            <a style="color: white; border-top-right-radius: 10rem; border-bottom-right-radius: 10rem; padding-top: 12px;" class="btn btn-info" id="button-addon2"><i class="fas fa-eye-slash" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 input-group">
                                        <input class="form-control form-control-user" type="password" id="ConfirmPasswordInput" placeholder="Confirmer le mot de passe" name="confirm-password">
                                        <div class="input-group-append">
                                            <a style="color: white; border-top-right-radius: 10rem; border-bottom-right-radius: 10rem; padding-top: 12px;" class="btn btn-info" id="button-addon2"><i class="fas fa-eye-slash" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <!-- Google Captcha -->
                                    <div class="g-recaptcha" data-sitekey="6Lc-Rs0aAAAAAMrPSbrIt2atdsc3w2pTSsho1Ukc"></div>
                                </div>
                                <button class="btn btn-info btn-block text-white btn-user" type="submit" name="submit">S'inscrire</button>
                                <hr>
                            </form>

                            <div class="small text-center">Vous avez-deja un compte? <u><a href="index.php?page=login">Se connecter</a></u></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once 'controllers/footer.php' ?>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>

    <script src="assets/js/alert-timeout.js"></script>
    <script src="assets/js/show-hide-pwd.js"></script>
</body>

</html>