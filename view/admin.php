<?php
require_once './models/userDAO.php';

use CitInterests\models\UserDAO;

if (!UserDAO::IsAdmin($_SESSION['connected_user_id'])) {
    header('location: index.php?page=login&message=error-not-connected');
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php require_once 'controllers/head.php' // -- head -- 
    ?>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php require_once 'controllers/navbar_admin.php' // -- navbar top --  
        ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php require_once 'controllers/navbar_top.php' // -- navbar top --  
                ?>
                <div class="container-fluid h-75" id="main-content">
                    <h3 class="text-dark mb-4 mt-5">Gestion Administrateur</h3>
                    <?php
                    // display message
                    if (isset($_SESSION['error-message']) && isset($_GET['message'])) {
                        echo $_SESSION['error-message'];
                    }
                    ?>

                    <div class="row row-cols-1 row-cols-md-2 g-4 mx-5 d-flex h-75">
                        <div class="col d-flex align-items-center">
                            <a href="index.php?page=admin_users">
                                <div class="card text-center admin-card" style="background: url(&quot;assets/img/other/admin-users-image.jpg&quot;);background-size: cover; height:400px; color:white">
                                    <div class="card-body p-0">
                                        <div class="admin-card-body"></div>
                                        <h2 class="card-title">Gestion des utilisateurs</h2>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col d-flex align-items-center">
                            <a href="index.php?page=admin_sights">
                                <div class="card text-center">
                                    <div class="card-body" style="background: url(&quot;assets/img/other/admin-sights-image.jpg&quot;);background-size: cover; height:400px">
                                        <h2 class="card-title">Gestion des centres d'intérêt</h2>
                                        <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                        <a href="#" class="card-link">Card link</a>
                                        <a href="#" class="card-link">Another link</a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <?php include_once 'controllers/footer.php'?>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/alert-timeout.js"></script>
</body>

</html>