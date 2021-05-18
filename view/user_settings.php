<?php
require_once 'controllers/user_settings_controller.php';
?>

<!DOCTYPE html>
<html>

<head>
    <?php require_once 'controllers/head.php' // -- head -- 
    ?>
</head>

<body id="page-top">
    <div id="wrapper">
        <div class="d-flex flex-column" id="content-wrapper">
                <?php require_once 'controllers/navbar_top.php' // -- navbar top -- 
                ?>
                <div class="container-fluid" id="main-content">
                    <h3 class="text-dark mb-4"></h3>
                    <?php
                    if (isset($_SESSION['error-message']) && isset($_GET['message'])) {
                        echo $_SESSION['error-message'];
                    } ?>
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <!-- USER PROFILE ICON -->
                                <div class="card-body text-center shadow"><img class="rounded-circle mb-3 mt-4" src="assets/img/profile_icon/<?= $old_image ?>" width="160" height="160" style="object-fit: cover">
                                    <form enctype="multipart/form-data" method="POST" style="box-shadow: none;">
                                        <label class="btn btn-yellow">
                                            Changer la photo <input type="file" name="icon_input" onchange="this.form.submit();" accept="image/x-png,image/gif,image/jpeg" hidden>
                                        </label>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col">
                                    <!-- Paramètres utilisateur -->
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3">
                                            <p class="m-0 font-weight-bold" style="color: #293250;">Paramètres de l'utilisateur</p>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST" action="index.php?page=user-settings">
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group"><label for="first_name"><strong>Prénom</strong></label><input class="form-control" type="text" id="first_name" placeholder="Votre prénom" name="first_name" value="<?= $old_firstname ?>"></div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group"><label for="last_name"><strong>Nom</strong></label><input class="form-control" type="text" id="last_name" placeholder="Votre nom" name="last_name" value="<?= $old_lastname ?>"></div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group"><label for="email">Adresse E-mail</strong></label><input class="form-control" type="email" id="email" placeholder="utilisateur@exemple.com" name="email" value="<?= $old_email ?>"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group"><button class="btn btn-yellow btn-sm" type="submit" name="submit-information">Sauvegarder</button></div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Paramètres mot de passe -->
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3">
                                            <p class="m-0 font-weight-bold" style="color: #293250;">Changer votre mot de passe</p>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST" action="index.php?page=user-settings">
                                                <div class="form-row">
                                                    <div class="col">
                                                        <label for="old_pwd"><strong>Ancien mot de passe</strong></label>
                                                        <div class="input-group mb-3" id="show_hide_password">
                                                            <input type="password" name="old_pwd" class="form-control" placeholder="" aria-label="" aria-describedby="button-addon2">
                                                            <div class="input-group-append">
                                                                <a style="color: black;" class="btn btn-yellow" id="button-addon2"><i class="fas fa-eye-slash" aria-hidden="true"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <label for="old_pwd"><strong>Nouveau mot de passe</strong></label>
                                                        <div class="input-group mb-3" id="show_hide_password">
                                                            <input type="password" name="new_pwd" class="form-control" placeholder="" aria-label="" aria-describedby="button-addon2">
                                                            <div class="input-group-append">
                                                                <a style="color: black;" class="btn btn-yellow" id="button-addon2"><i class="fas fa-eye-slash" aria-hidden="true"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <label for="old_pwd"><strong>Confirmer le nouveau mot de passe</strong></label>
                                                        <div class="input-group mb-3" id="show_hide_password">
                                                            <input type="password" name="new_pwd_confirm" class="form-control" placeholder="" aria-label="" aria-describedby="button-addon2">
                                                            <div class="input-group-append">
                                                                <a style="color: black;" class="btn btn-yellow" id="button-addon2"><i class="fas fa-eye-slash" aria-hidden="true"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group"><button class="btn btn-yellow btn-sm" type="submit" name="submit-new-pwd">Confirmer</button></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <?php include_once 'controllers/footer.php' ?>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="assets/js/alert-timeout.js"></script>
    <script src="assets/js/show-hide-pwd.js"></script>
</body>

</html>