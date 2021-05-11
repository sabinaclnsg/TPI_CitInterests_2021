<?php
require_once './models/sightsDAO.php';

use CitInterests\models\SightsDAO;

if (isset($_GET['id'])) {
    $sight_info = SightsDAO::GetSightById($_GET['id'])[0];

    $today_day = date('l'); // returns today's day (example : Monday)
    $status = 'Fermé'; // closed/open status
    $timestamp = time();
    $time_now = (new DateTime())->setTimestamp($timestamp)->format('H:i');  // returns time now


    $user = SightsDAO::GetUserOfSights($sight_info['id']);
    $opening_hour = SightsDAO::GetOpeningHourByDay($today_day, $sight_info['id'])[$today_day];
    $closing_hour = SightsDAO::GetClosingHourByDay($today_day, $sight_info['id'])[$today_day];

    if ($opening_hour < $time_now && $time_now < $closing_hour || SightsDAO::IsOpen24h($sight_info['id'])) { // if time now is within the range of open hours 
        $status = '<span class="text-success"> Ouvert</span>';
    } else {
        $status = '<span class="text-danger"> Closed</span>';
    }
} else {
    header('location: index.php?page=homepage');
}


?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Page d'accueil - CitInterests</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <!-- fade animation on load -->
    <link rel="stylesheet" href="assets/css/load-animation.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <div class="d-flex flex-column" id="content-wrapper">
            <?php require_once 'controllers/navbar_top.php' // -- navbar top --  
            ?>
            <div id="main-content">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent">
                        <li class="breadcrumb-item"><a href="index.php?page=homepage">Page d'accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Jet d'eau</li>
                    </ol>
                </nav>
                <section class="container-fluid my-5 mx-5">
                    <div class="row">
                        <div class="col-4">
                            <img src="assets/img/sights/<?= $sight_info['image'] ?>" class="img-fluid" alt="<?= $sight_info['image'] ?>">
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <h1 class="col-12"><?= $sight_info['name'] ?></h1>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-4">
                                    <h5>Horaires :</h5>
                                    Lundi
                                    Mardi
                                </div>
                                <div class="col-4">
                                    <h5>Tarifs :</h5>
                                    <?= ($sight_info['price'] == 0 ? 'Gratuit' : $sight_info['price']) ?>
                                </div>
                                <div class="col-4">
                                    <h5><i class="fas fa-clock"></i><?= $status ?></h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <h4 class="col-12">Description :</h4>
                            </div>
                            <div class="row">
                                <span class="col-12"><?= $sight_info['description'] ?></span>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <a class="text-right col-6" style="cursor: pointer; text-decoration: none; color: black" href="index.php?page=user&id=<?$user[0]['id']?>">
                            <img class="border rounded-circle img-profile" style="height: 30px;" src="assets/img/profile_icon/<?$user[0]['image']?>">
                            <span class="d-none d-lg-inline text-gray-600 small"><?= $user[0]['firstname'] . " " . $user[0]['lastname'] ?></span>
                        </a>
                    </div>
                </section>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Brand 2021</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
</body>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/chart.min.js"></script>
<script src="assets/js/bs-init.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
<script src="assets/js/theme.js"></script>
<script src="assets/js/alert-timeout.js"></script>

</html>