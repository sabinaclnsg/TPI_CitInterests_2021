<?php
require_once './models/userDAO.php';

use CitInterests\models\UserDAO;

$user_dao = new UserDAO();
if (!$user_dao->IsAdmin($_SESSION['connected_user_id'])) {
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
                    <h1 class="text-dark mb-4 mt-5 text-center">Gestion Administrateur</h1>
                    <?php
                    // display message
                    if (isset($_SESSION['error-message']) && isset($_GET['message'])) {
                        echo $_SESSION['error-message'];
                    }
                    ?>

                    <div class="container-fluid">
                        <div class="row g-2" style="vertical-align: middle;">
                            <a href="index.php?page=admin_users" class="col-lg-5 col-md-12 text-center admin-block" style="background: url(&quot;assets/img/other/admin-users-image.jpg&quot;);background-size: cover; background-position:50%;">
                                <span class="p-3" style="font-size: 50px; color: white">Gestion des utilisateurs</span>
                            </a>
                            <a href="index.php?page=admin_sights&page_no=1" class="col-lg-5 col-md-12 mt-md-3 text-center admin-block" style="background: url(&quot;assets/img/other/admin-sights-image.jpg&quot;);background-size: cover; background-position:50%;">
                                <span class="p-3" style="font-size: 40px; color: white">Gestion des centres d'intérêts</span>
                            </a>
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
    <script src="assets/js/alert-timeout.js"></script>
</body>

</html>