<?php

namespace CitInterests\controllers;

require_once './models/sightsDAO.php';
require_once './models/userDAO.php';

use CitInterests\models\UserDAO;
use CitInterests\models\SightsDAO;

$user_dao = new UserDAO();
$days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.', 'Dim.');

if (!($_SESSION['connected'])) { // if user isnt connected, redirect to homepage
    header('location: ./index.php?message=error-not-connected&page=login'); // user not connected
} else if ($user_dao->IsBanned($_SESSION['connected_user_id'])) {
    header('location: ./index.php?message=error-banned-user&page=homepage'); // user banned
}
class Sights
{
    public static function CreateSight()
    {
        $sights_dao = new SightsDAO();

        $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.', 'Dim.');
        $days_display = array('Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.', 'Dim.');

        $sights_name = filter_input(INPUT_POST, 'sights_name', FILTER_SANITIZE_STRING);
        $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $adress = filter_input(INPUT_POST, 'adress', FILTER_SANITIZE_STRING);
        $canton = filter_input(INPUT_POST, 'canton');

        $opening_hours = array();
        $closing_hours = array();
        $default_hour = '00:00';

        for ($i = 0; $i < 7; $i++) { // filters every day opening/closing hours from post
            $opening_hour = filter_input(INPUT_POST, $days[$i] . '_opening_hours', FILTER_SANITIZE_STRING);
            $closing_hour = filter_input(INPUT_POST, $days[$i] . '_closing_hours', FILTER_SANITIZE_STRING);

            array_push($opening_hours, $opening_hour);
            array_push($closing_hours, $closing_hour);
        }

        $file_path = 'assets/img/sights/'; // root folder of sights images


        $sights_contains_category = $_POST['category'];
        $sights_has_age_limit = $_POST['age_limit'];

        if (!empty($sights_name) && !empty($description) && !empty($adress) && !empty($canton) && !empty($canton) && !empty($_FILES['image_file']) && !empty($sights_contains_category) && !empty($sights_has_age_limit)) {

            if ($price >= 1 || isset($_POST['price_free'])) { // checks if both price input and checkbox are empty
                $image_file = $_FILES['image_file'];
                $tmp_name = $image_file['name'];

                if ($image_file['error'] === UPLOAD_ERR_OK) {
                    $img_name = explode('.', $tmp_name);
                    $image_type = $img_name[1];

                    $img_name = $img_name[0] . uniqid() . "." . $image_type; // creates a random name for the image using uniqid()
                    move_uploaded_file($image_file['tmp_name'], $file_path . $img_name);

                    try {
                        if (empty($price)) { // if price input is empty, automatically send "price" as 0 = free
                            $id_sights = SightsDAO::CreateSight($sights_name, 0, $description, $adress, $canton, $img_name, $_SESSION['connected_user_id']);
                        } else {
                            $id_sights = SightsDAO::CreateSight($sights_name, $price, $description, $adress, $canton, $img_name, $_SESSION['connected_user_id']);
                        }

                        // opening/closing hours
                        if (isset($_POST['open_24h'])) { // if open 24h checkbox is checked
                            SightsDAO::CreateOpeningHours($default_hour, $default_hour, $default_hour, $default_hour, $default_hour, $default_hour, $default_hour, $id_sights);
                            SightsDAO::CreateClosingHours($default_hour, $default_hour, $default_hour, $default_hour, $default_hour, $default_hour, $default_hour, $id_sights);
                        } else {
                            SightsDAO::CreateOpeningHours($opening_hours[0], $opening_hours[1], $opening_hours[2], $opening_hours[3], $opening_hours[4], $opening_hours[5], $opening_hours[6], $id_sights);
                            SightsDAO::CreateClosingHours($closing_hours[0], $closing_hours[1], $closing_hours[2], $closing_hours[3], $closing_hours[4], $closing_hours[5], $closing_hours[6], $id_sights);
                        }

                        // link categories to sights
                        foreach ($sights_contains_category as $category) {
                            SightsDAO::LinkCategoryToSights($category, $id_sights);
                        }
                        // link age limits to sights
                        foreach ($sights_has_age_limit as $age_limit) {
                            SightsDAO::LinkAgeLimitToSights($age_limit, $id_sights);
                        }

                        header('location: ./index.php?page=homepage&message=success-proposition');
                    } catch (\Throwable $th) {
                        throw $th;
                    }
                }
            } else {
                header('location: ./index.php?message=error-email&page=create_sights'); // not all inputs are filled
            }
        } else {
            header('location: ./index.php?message=error-login&page=create_sights'); // not all inputs are filled
        }
    }
}
