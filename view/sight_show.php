<?php
require_once './models/sightsDAO.php';

use CitInterests\models\SightsDAO;

if (isset($_GET['id'])) {

    $sights_dao = new SightsDAO();

    $sight_info = $sights_dao->GetSightById($_GET['id']);

    $today_day = date('l'); // returns today's day (example : Monday)
    $status = 'Fermé'; // closed/open status
    $timestamp = time();
    $time_now = (new DateTime())->setTimestamp($timestamp)->format('H:i');  // returns time now
    $days_fr = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

    $user = $sights_dao->GetUserOfSights($sight_info['id']);
    $opening_hour = $sights_dao->GetOpeningHourByDay($today_day, $sight_info['id'])[$today_day];
    $closing_hour = $sights_dao->GetClosingHourByDay($today_day, $sight_info['id'])[$today_day];

    if ($opening_hour < $time_now && $time_now < $closing_hour || $sights_dao->IsOpen24h($sight_info['id'])) { // if time now is within the range of open hours 
        $status = '<span class="text-success"> Ouvert</span>'; // status open
    } else {
        $status = '<span class="text-danger"> Fermé</span>'; // status closed
    }
} else {
    header('location: index.php?page=homepage');
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
        <div class="d-flex flex-column" id="content-wrapper">
            <?php require_once 'controllers/navbar_top.php' // -- navbar top --  
            ?>
            <div id="main-content">
                <section class="container my-5">
                    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="index.php?page=homepage">Page d'accueil</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= $sight_info['name'] ?></li>
                        </ol>
                    </nav>
                    <!-- Title Section -->
                    <div class="row">
                        <h1 class="col"><b><?= $sight_info['name'] ?></b></h1>
                    </div>
                    <div class="row">
                        <!-- Image Section -->
                        <div class="col-lg-8 col-md-12">
                            <img src="assets/img/sights/<?= $sight_info['image'] ?>" class="img-fluid" alt="<?= $sight_info['image'] ?>">
                        </div>
                        <!-- Opening/Closing Hours, Pricing Section -->
                        <div class="col-lg-4 col-md-12">
                            <div class="card mt-3 mt-lg-0" style="height: 100%;">
                                <div class="card-body">
                                    <h3 class="card-title d-flex justify-content-center"><b>Horaires</b></h3>
                                    <hr>
                                    <p class="text-center mb-1"><i class="fas fa-clock"></i><?= $status ?></p>
                                    <table class=" d-flex justify-content-center">
                                        <?php
                                        if ($sights_dao->IsOpen24h($sight_info['id']) == false) {
                                            $counter = 0;
                                            foreach ($days as $day) {
                                                $opening_hours = $sights_dao->GetOpeningHourByDay($day, $sight_info['id'])[0];
                                                $closing_hours = $sights_dao->GetClosingHourByDay($day, $sight_info['id'])[0];

                                                if ($opening_hours == '00:00:00' || $closing_hours == '00:00:00') { // verifies if opening/closing hours are 00:00:00 to display closed status
                                                    echo '<tr><th class=\'pr-3\'>' . $days_fr[$counter] . '</th><td style=\'color:red;\'>Fermé</td><tr>';
                                                } else {
                                                    echo '<tr><th class=\'pr-3\'>' . $days_fr[$counter] . '</th><td>' . date('H\hi', strtotime($opening_hours)) . ' - ' . date('H\hi', strtotime($closing_hours)) . '</td><tr>';
                                                }
                                                $counter++;
                                            }
                                        } else {
                                            echo '<p class=\'d-flex justify-content-center\'>Ouvert 24/7</p>';
                                        }
                                        ?>
                                    </table>
                                    <h3 class="card-title d-flex justify-content-center mt-4"><b>Tarif</b></h3>
                                    <hr>
                                    <p class="card-text d-flex justify-content-center"><?= ($sight_info['price'] != 0 ? 'Adulte : ' . $sight_info['price'] . 'CHF' : 'Gratuit') ?></p>
                                    <hr>
                                    <p class="card-text d-flex justify-content-center">Téléphone : <?=$sight_info['telephone']?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card mt-4">
                                <div class="card-body">
                                    <!-- Description Section -->
                                    <h3 class="card-title"><b>Description</b></h3>
                                    <p class="card-text text-justify"><?= $sight_info['description'] ?></p>
                                    <hr>
                                    <!-- Categories/Age Section -->
                                    <div class="row my-5">
                                        <?php
                                        foreach ($sights_dao->GetSightAge($sight_info['id']) as $a) {
                                            $age_limit = $a['name'];
                                            require 'controllers/icons_show.php'; // controller for icons
                                            echo '<div class=\'col-xl-3 col-md-6 col-lg-6\'><label class=\'btn btn-yellow pt-2\' style=\'height:48px; font-size:19px;width:100%\'>' .
                                                $age_icon . '&nbsp;' .
                                                $age_limit
                                                . "</label></div>";
                                        }
                                        foreach ($sights_dao->GetSightCategory($sight_info['id']) as $c) {
                                            $category = $c['name'];
                                            require 'controllers/icons_show.php'; // controller for icons
                                            echo '<div class=\'col-xl-3 col-md-6 col-lg-6\'><label class=\'btn btn-yellow pt-2\' style=\'height:48px; font-size:19px;width:100%\'>' .
                                                $category_icon . '&nbsp;' .
                                                $category
                                                . "</label></div>";
                                        }
                                        ?>
                                    </div>
                                    <hr>
                                    <!-- MAP DISPLAY -->
                                    <div class="row my-5">
                                        <div class="col-lg-8 col-12">
                                            <?php
                                            require_once './controllers/map.php';

                                            // get lat and lon with adress
                                            $lat = getLatLonWithAdress($sight_info['adress'])[0];
                                            $lon = getLatLonWithAdress($sight_info['adress'])[1];

                                            ?>
                                            <!-- Map Section -->
                                            <input type="hidden" id="lat" value="<?= $lat ?>">
                                            <input type="hidden" id="lon" value="<?= $lon ?>">
                                        </div>
                                        <div class="col-lg-4 col-12">
                                            <h3 class="card-title"><b>Adresse</b></h3>
                                            <p><?= $sight_info['adress'] ?></p>
                                            <p>Téléphone : <?=$sight_info['telephone']?></p>
                                            <a href="https://maps.google.com/?q=<?= $lat ?>,<?= $lon ?>" target="_blank">
                                                <div class="btn btn-yellow">Ouvrir la carte</div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
            </div>
    <?php include_once 'controllers/footer.php' ?>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script>
        initializeMap(document.getElementById('lat').value, document.getElementById('lon').value);
    </script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/alert-timeout.js"></script>
</body>


</html>