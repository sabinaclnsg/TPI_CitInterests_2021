<?php
// gets data from ajax POST

require_once '../models/sightsDAO.php';
require_once '../controllers/filter_controller.php';

use CitInterests\controllers\Filter;
use CitInterests\models\SightsDAO;

$sights_dao = new SightsDAO();
$filter = new Filter();

$today_day = date('l'); // returns today's day (example : Monday)
$status = 'Fermé'; // closed/open status
$timestamp = time();
$time_now = (new DateTime())->setTimestamp($timestamp)->format('H:i');  // returns time now
$result = "";
$img_file_path = 'assets/img/sights/';

if (isset($_POST['filter_data']) && $_POST['filter_data'] != 'empty') {

    // arrays filled with id
    $categories_array = array();
    $ages_array = array();
    $cantons_array = array();
    $budget_array = array();

    foreach ($_POST['filter_data'] as $data) {
        if ($sights_dao->GetCategoryIdByName($data) != false) { // checks if data entered is a category and if it exists
            array_push($categories_array, $data);
        } else if ($sights_dao->GetAgeIdByName($data) != false) { // checks if data entered is an age_limit and if it exists
            array_push($ages_array, $data);
        } else if (in_array($data, $cantons)) { // checks if data entered is a canton and if it exists
            array_push($cantons_array, $data);
        } else if ($sights_dao->FilterByBudget($data) != false) { // checks if data entered is a budget and if it exists
            array_push($budget_array, $data);
        }
    }

    //echo $sights_dao->Filter($cantons_array, $categories_array, $ages_array, $budget_array);

    foreach ($sights_dao->Filter($cantons_array, $categories_array, $ages_array, $budget_array) as $sight_show) {
        $user = $sights_dao->GetUserOfSights($sight_show['id']);
        $opening_hour = $sights_dao->GetOpeningHourByDay($today_day, $sight_show['id'])[$today_day];
        $closing_hour = $sights_dao->GetClosingHourByDay($today_day, $sight_show['id'])[$today_day];

        if ($opening_hour < $time_now && $time_now < $closing_hour || $sights_dao->IsOpen24h($sight_show['id'])) { // if time now is within the range of open hours 
            $status = '<span style="color:green">Ouvert</span>';
        } else {
            $status = '<span class="text-danger">Closed</span>';
        }
        $result .= $filter->FilterSights($sight_show, $img_file_path, $status);
    }

    echo $result;
} else if (isset($_POST['search_data'])) { // if user searched

    foreach ($sights_dao->Search($_POST['search_data']) as $sight_show) {
        $user = $sights_dao->GetUserOfSights($sight_show['id']);
        $opening_hour = $sights_dao->GetOpeningHourByDay($today_day, $sight_show['id'])[$today_day];
        $closing_hour = $sights_dao->GetClosingHourByDay($today_day, $sight_show['id'])[$today_day];

        if ($opening_hour < $time_now && $time_now < $closing_hour || $sights_dao->IsOpen24h($sight_show['id'])) { // if time now is within the range of open hours 
            $status = '<span style="color:green">Ouvert</span>';
        } else {
            $status = '<span class="text-danger">Closed</span>';
        }
        $result .= $filter->FilterSights($sight_show, $img_file_path, $status);
    }

    echo $result;
} else { // if no filter is used
    foreach ($sights_dao->GetValidatedSights() as $sight_show) {
        $user = $sights_dao->GetUserOfSights($sight_show['id']);
        $opening_hour = $sights_dao->GetOpeningHourByDay($today_day, $sight_show['id'])[$today_day];
        $closing_hour = $sights_dao->GetClosingHourByDay($today_day, $sight_show['id'])[$today_day];

        if ($opening_hour < $time_now && $time_now < $closing_hour || $sights_dao->IsOpen24h($sight_show['id'])) { // if time now is within the range of open hours 
            $status = '<span style="color:green">Ouvert</span>';
        } else {
            $status = '<span class="text-danger">Closed</span>';
        }

        $result .= $filter->FilterSights($sight_show, $img_file_path, $status);
    }

    echo $result;
}
