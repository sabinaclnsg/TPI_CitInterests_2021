<?php
require_once '../models/sightsDAO.php';

use CitInterests\models\SightsDAO;

$sights_dao = new SightsDAO();

$today_day = date('l'); // returns today's day (example : Monday)
$status = 'Fermé'; // closed/open status
$timestamp = time();
$time_now = (new DateTime())->setTimestamp($timestamp)->format('H:i');  // returns time now
$result = "";
$img_file_path = 'assets/img/sights/';

if (isset($_POST['filter_data']) && $_POST['filter_data'] != 'empty') {
    $sights_dao->ResetSightShow();


    $ids = array();

    foreach ($_POST['filter_data'] as $data) {
        if ($sights_dao->FilterByCanton($data) != "") { // checks if data entered is a canton and if it exists
            array_push($ids, SightsDAO::FilterByCanton($data));
        }
        if ($sights_dao->GetCategoryIdByName($data) != 0) { // checks if data entered is a category and if it exists
            array_push($ids, SightsDAO::FilterByCategory(SightsDAO::GetCategoryIdByName($data)[0]));
        }
        if ($sights_dao->GetAgeIdByName($data) != 0) { // checks if data entered is an age_limit and if it exists
            array_push($ids, SightsDAO::FilterByAge(SightsDAO::GetAgeIdByName($data)[0]));
        }
        if ($sights_dao->FilterByBudget($data) != "") { // checks if data entered is a budget and if it exists
            array_push($ids, SightsDAO::FilterByBudget($data));
        }
    }

    foreach ($ids as $id) {
        foreach ($id as $id_sight) {
            $sights_dao->UpdateSightShow($id_sight[0]);
        }
    }

    foreach ($sights_dao->GetShowedSights() as $sight_show) {
        $user = $sights_dao->GetUserOfSights($sight_show['id']);
        $opening_hour = $sights_dao->GetOpeningHourByDay($today_day, $sight_show['id'])[$today_day];
        $closing_hour = $sights_dao->GetClosingHourByDay($today_day, $sight_show['id'])[$today_day];

        if ($opening_hour < $time_now && $time_now < $closing_hour || $sights_dao->IsOpen24h($sight_show['id'])) { // if time now is within the range of open hours 
            $status = '<span style="color:green">Ouvert</span>';
        } else {
            $status = '<span class="text-danger">Closed</span>';
        }
        $result .= "<div class=\"col-sm-12 col-md-6 col-lg-4 col-xl-3 my-3\">
    <a href=\"index.php?page=sight_show&id=". $sight_show['id'] ."\" style=\"color:black; text-decoration:none\"><div class=\"card h-100\">
        <img src=\"" . $img_file_path . $sight_show['image'] . "\" class=\"card-img-top\" alt=\"" . $sight_show['image'] . "\" style=\"\">
        <div class=\"card-body\" style=\"height:180px\">
            <h4 class=\"card-title\">
                <b>" . $sight_show['name'] . " | <h6 class=\"d-inline\"><i class=\"fas fa-clock\"></i>&nbsp; $status</h6></b>
            </h4>
            <hr>
            <p class=\"card-text text-overflow crop-text-3\">" . $sight_show['description'] . "</p>
        </div>
        <div class=\"card-footer\" style=\"height:80px\">
            <div class=\"row\">
                <div class=\"col-6 d-flex align-items-center\">" .
            ($sight_show['price'] == 0 ? '<span style="color:green">Gratuit</span>' : '<span class=\"text-primary\">' . $sight_show['price'] . ' CHF</span>')
            . "</div>
            </div><div class=\"\">";
        foreach ($sights_dao->GetSightAge($sight_show['id']) as $a) {
            $result .= "<label class=\"btn btn-secondary px-1\" style=\"height:24px; font-size:12px; padding:2px; margin-left: 1.5px;margin-right: 1.5px;\">".
                $a['name']
                ."</label>";
        }
        foreach ($sights_dao->GetSightCategory($sight_show['id']) as $c) {
            $result .= "<label class=\"btn btn-secondary px-1\" style=\"height:24px; font-size:12px; padding:2px; margin-left: 1.5px;margin-right: 1.5px;\">".
                $c['name']
                ."</label>";
        }
        $result .= "</div></div>
        </div></a>
</div>";
    }

    echo $result;
} else {
    foreach ($sights_dao->GetValidatedSights() as $sight_show) {
        $user = $sights_dao->GetUserOfSights($sight_show['id']);
        $opening_hour = $sights_dao->GetOpeningHourByDay($today_day, $sight_show['id'])[$today_day];
        $closing_hour = $sights_dao->GetClosingHourByDay($today_day, $sight_show['id'])[$today_day];

        if ($opening_hour < $time_now && $time_now < $closing_hour || $sights_dao->IsOpen24h($sight_show['id'])) { // if time now is within the range of open hours 
            $status = '<span style="color:green">Ouvert</span>';
        } else {
            $status = '<span class="text-danger">Closed</span>';
        }
        $result .= "<div class=\"col-sm-12 col-md-6 col-lg-4 col-xl-3 my-3\">
    <a href=\"index.php?page=sight_show&id=". $sight_show['id'] ."\" style=\"color:black; text-decoration:none\">
        <div class=\"card h-100\">
        <div class=\"row sight-card\">
            <div class=\"col-5 col-md-12 sight-image-body\">
                <img src=\"" . $img_file_path . $sight_show['image'] . "\" class=\"card-img-top sight-image\" alt=\"" . $sight_show['image'] . "\" style=\"\">
            </div>
            <div class=\"col-7 col-md-12 sight-body-1\">
                <div class=\"card-body p-0 p-md-3 sight-body-2\" style=\"height:180px\">
                    <h4 class=\"card-title\">
                        <b>" . $sight_show['name'] . "<h6 class=\"d-inline sight-status-1\"> | <i class=\"fas fa-clock\"></i>&nbsp; $status</h6></b>
                    </h4>
                    <hr>
                    <p class=\"card-text text-overflow crop-text-3\">" . $sight_show['description'] . "</p>
                </div>
                <div class=\"card-footer p-0 p-md-3 sight-footer\" >
                    <div class=\"row\">
                        <div class=\"col-6 mb-2 d-flex align-items-center\">" .
                            ($sight_show['price'] == 0 ? '<span style="color:green">Gratuit</span>' : '<span class=\"text-primary\">' . $sight_show['price'] . ' CHF</span>')
                    .  "</div>
                    <div class\"col-6 sight-status-2\" style=\"width:50%\"><h6 class=\"float-right d-md-none pr-4 m-0 pt-1\">$status</h6></div>
                    </div>
                    <div class=\"d-none d-md-block\">";
                    foreach ($sights_dao->GetSightAge($sight_show['id']) as $a) {
                        $result .= "<label class=\"btn btn-secondary px-1\" style=\"height:28px; font-size:15px; padding:2px; margin-left: 3px;margin-right: 3px;\">".
                            $a['name']
                            ."</label>";
                    }
                    foreach ($sights_dao->GetSightCategory($sight_show['id']) as $c) {
                        $result .= "<label class=\"btn btn-secondary px-1\" style=\"height:28px; font-size:15px; padding:2px; margin-left: 3px;margin-right: 3px;\">".
                            $c['name']
                            ."</label>";
                    }
                    $result .= "
                    </div>
                </div>
            </div>
        </div>
        </div>
    </a>
</div>";
    }

    echo $result;
}