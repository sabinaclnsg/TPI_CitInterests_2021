<?php
require_once 'controllers/logout_controller.php';
require_once './models/userDAO.php';

use SiteTemplate\models\UserDAO;

if ($_SESSION['connected'] == true) { // checks if user is connected
    $user_connected = true; // hide profile display on the top right of the page

    $user_data = UserDAO::GetUserData_ParamId($_SESSION['connected_user_id']);
    $user_admin = UserDAO::IsAdmin($_SESSION['connected_user_id']);
    $firstname = $user_data[0]['firstname'];
    $lastname = $user_data[0]['lastname'];
    $profile_icon = $user_data[0]['image'];

    if ($_GET['page'] == 'admin') {
        $logo_hidden = true;
    }
} else {
    $firstname = "";
    $lastname = "";
    $email = "";

    $user_admin = false;
    $user_connected = false;
    $profile_icon = 'profile-user-not-connected.svg'; // default icon
}
?>

<nav class="navbar navbar-light navbar-expand bg-white shadow topbar static-top">
    <div class="container-fluid">
        <a href="index.php?page=homepage" <?= ($user_admin && str_contains($_GET['page'], 'admin') ? "hidden" : "") ?>><img class="img-profile" style="width: 50px; height: 50px;" src="assets/img/other/LogoCitInterests.svg"></a>
        <form class="form-inline d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ..." <?= ($_GET['page'] != 'homepage' ? 'hidden' : '') ?>>
                <div class="input-group-append" <?= ($_GET['page'] != 'homepage' ? 'hidden' : '') ?>><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
            </div>
        </form>

        <ul class="nav navbar-nav navbar-center text-center d-none d-lg-block" style="margin-right: 1%;">
        <li><img class="img-profile" style="height: 30px;" src="assets/img/other/TexteCitInterests.png"></li>
        </ul>
        <!-- DISPLAY PROFILE TOP RIGHT -->
        <ul class="navbar-nav flex-nowrap ml-auto">
            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-toggle="dropdown" href="#"><i class="fas fa-search"></i></a>
                <div class="dropdown-menu dropdown-menu-right p-3 animated--grow-in" aria-labelledby="searchDropdown">
                    <form class="form-inline mr-auto navbar-search w-100">
                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                            <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                        </div>
                    </form>
                </div>
            </li>
            <!-- NOTIFICATIONS -->
            <li class="nav-item dropdown no-arrow mx-1" <?= (!$user_connected ? 'hidden' : '') ?>>
                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-toggle="dropdown" href="#"><span class="badge badge-danger badge-counter">3+</span><i class="fas fa-bell fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-list animated--grow-in">
                        <h6 class="dropdown-header">alerts center</h6><a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="mr-3">
                                <div class="bg-primary icon-circle"><i class="fas fa-file-alt text-white"></i></div>
                            </div>
                            <div><span class="small text-gray-500">December 12, 2019</span>
                                <p>A new monthly report is ready to download!</p>
                            </div>
                        </a><a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="mr-3">
                                <div class="bg-success icon-circle"><i class="fas fa-donate text-white"></i></div>
                            </div>
                            <div><span class="small text-gray-500">December 7, 2019</span>
                                <p>$290.29 has been deposited into your account!</p>
                            </div>
                        </a><a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="mr-3">
                                <div class="bg-warning icon-circle"><i class="fas fa-exclamation-triangle text-white"></i></div>
                            </div>
                            <div><span class="small text-gray-500">December 2, 2019</span>
                                <p>Spending Alert: We've noticed unusually high spending for your account.</p>
                            </div>
                        </a><a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                    </div>
                </div>
            </li>


            <div class="d-none d-sm-block <?= ($user_connected ? 'topbar-divider' : '') ?>"></div>


            <li class="nav-item dropdown no-arrow">
                <div class="nav-item dropdown no-arrow">
                    <a class="dropdown-toggle nav-link" aria-expanded="false" data-toggle="dropdown" href="#">
                        <span class="d-none d-lg-inline mr-2 text-gray-600 small"><?= $firstname . " " . $lastname ?></span>
                        <img class="border rounded-circle img-profile" src="assets/img/profile_icon/<?=$profile_icon?>">
                    </a>

                    <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in">
                        <!-- DROPDOWN FOR WHEN USER IS CONNECTED -->
                        <div <?= (!$user_connected ? 'hidden' : '') ?>>
                            <a class="dropdown-item" href="index.php?page=user"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Profil</a>
                            <a class="dropdown-item" href="index.php?page=user-settings"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Paramètres</a>
                            <a class="dropdown-item" href="index.php?page=admin" <?= (!$user_admin ? "hidden" : "") ?>><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Administration</a>

                            <div class="dropdown-divider"></div>
                            <form action="index.php?page=login" method="POST">
                                <button class="dropdown-item" type="submit" name="logout"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Se déconnecter</button>
                            </form>
                        </div>

                        <!-- DROPDOWN FOR WHEN USER IS NOT CONNECTED -->
                        <div <?= ($user_connected ? 'hidden' : '') ?>>
                            <a class="dropdown-item" href="index.php?page=register"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Inscription</a>
                            <a class="dropdown-item" href="index.php?page=login"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Se connecter</a>
                        </div>

                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>