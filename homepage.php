<?php
require_once './models/sightsDAO.php';

use SiteTemplate\models\SightsDAO;

$count_validated_sights = SightsDAO::CountValidatedSights()[0];
$sights = SightsDAO::GetValidatedSights();
$img_file_path = 'assets/img/sights/';

$today_day = date('l'); // returns today's day (example : Monday)
$status = 'Fermé'; // closed/open status
$timestamp = time();
$time_now = (new DateTime())->setTimestamp($timestamp)->format('H:i');  // returns time now
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
                <section class="py-5 text-center container">
                    <?php
                    if (isset($_SESSION['error-message']) && isset($_GET['message'])) {
                        echo $_SESSION['error-message'];
                    }
                    ?>
                    <div class="row py-lg-5">
                        <div class="col-lg-6 col-md-8 mx-auto">
                            <h1 class="fw-light">Centres d'intérêt</h1>
                            <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
                            <p>
                                <a href="index.php?page=create_sights" class="btn btn-yellow my-2">Proposer un centre d'intérêt</a>
                            </p>
                        </div>
                    </div>
                    <?php require_once 'controllers/filter.php' // -- navbar top -- 
                    ?>
                    <hr>
                </section>
                <div class="row row-cols-1 row-cols-md-4 g-4 m-5">
                    <?php
                    for ($i = 0; $i < $count_validated_sights; $i++) {
                        $user = SightsDAO::GetUserOfSights($sights[$i]['id']);
                        $opening_hour = SightsDAO::GetOpeningHourByDay($today_day, $sights[$i]['id'])[$today_day];
                        $closing_hour = SightsDAO::GetClosingHourByDay($today_day, $sights[$i]['id'])[$today_day];

                        if ($opening_hour < $time_now && $time_now < $closing_hour) { // if time now is within the range of open hours 
                            $status = '<span class="text-success">Ouvert</span>';
                        } else {
                            $status = '<span class="text-danger">Closed</span>';
                        }
                    ?>
                        <div class="col my-3">
                            <div class="card h-100">
                                <img src="<?= $img_file_path . $sights[$i]['image'] ?>" class="card-img-top" alt="<?= $sights[$i]['image'] ?>">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <b><?= $sights[$i]['name'] ?> | <h6 class="d-inline"><i class="fas fa-clock"></i> <?= $status ?></h6></b>
                                    </h4>
                                    <hr>
                                    <p class="card-text text-overflow"><?= $sights[$i]['description'] ?></p>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-6 d-flex align-items-center">
                                            <?= ($sights[$i]['price'] == NULL ? '<span class="text-success">Gratuit</span>' : '<span class="text-primary">' . $sights[$i]['price'] . ' CHF</span>') ?>
                                        </div>
                                        <a class="text-right col-6" style="cursor: pointer; text-decoration: none; color: black" href="index.php?page=user&id=<?= $user[0]['id'] ?>">
                                            <img class="border rounded-circle img-profile" style="height: 30px;" src="assets/img/profile_icon/<?=$user[0]['image']?>">
                                            <span class="d-none d-lg-inline text-gray-600 small"><?= $user[0]['firstname'] . " " . $user[0]['lastname'] ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Brand 2021</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
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