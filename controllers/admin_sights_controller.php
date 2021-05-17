<?php
require_once './models/userDAO.php';
require_once './models/sightsDAO.php';

use CitInterests\models\SightsDAO;
use CitInterests\models\UserDAO;

$user_dao = new UserDAO();

if (!$user_dao->IsAdmin($_SESSION['connected_user_id'])) {
    header('location: index.php?page=login&message=error-not-connected');
}

$sights_dao = new SightsDAO();

$count_sights = $sights_dao->CountSights()[0];
$count_columns = $sights_dao->CountColumns();
$column_names = $sights_dao->GetColumnNames();
$sights = $sights_dao->GetSights();
$cantons = array('Genève', 'Fribourg', 'Vaud', 'Valais', 'Neuchâtel', 'Jura');
$column_names_fr = array('ID', 'Nom', 'Canton', 'Adresse', 'Description', 'Prix', 'Image', 'Valider', 'Supprimer', 'Afficher', 'ID utilisateur');

$id_sights = filter_input(INPUT_POST, 'id_sight', FILTER_SANITIZE_STRING);
$delete_sight_id = filter_input(INPUT_POST, 'delete_sight_id', FILTER_SANITIZE_STRING);

$name = filter_input(INPUT_POST, 'name_' . $id_sights, FILTER_SANITIZE_STRING);
$canton = filter_input(INPUT_POST, 'canton_' . $id_sights, FILTER_SANITIZE_STRING);
$adress = filter_input(INPUT_POST, 'adress_' . $id_sights, FILTER_SANITIZE_STRING);
$description = filter_input(INPUT_POST, 'description_' . $id_sights, FILTER_SANITIZE_STRING);
$price = filter_input(INPUT_POST, 'price_' . $id_sights, FILTER_SANITIZE_STRING);

if (isset($_POST['submit_modify_sight'])) { // if modifications are submitted
    $old_image = $sights_dao->GetSightImage($id_sights)[0];
    $new_image = "";

    if (isset($_POST['is_validated_' . $id_sights])) {
        $is_validated = 1;
    } else {
        $is_validated = 0;
    }

    if (isset($_POST['is_requested_' . $id_sights])) {
        $is_requested = 1;
    } else {
        $is_requested = 0;
    }

    if (isset($_POST['is_showed_' . $id_sights])) {
        $is_showed = 1;
    } else {
        $is_showed = 0;
    }

    if ($_FILES['image_' . $id_sights]['name'] != '') { // if image file is set
        unlink("assets/img/sights/$old_image"); // delete old sight image from folder 

        $image_file = $_FILES['image_' . $id_sights];
        $tmp_name = $image_file['name'];

        $img_name = explode('.', $tmp_name);
        $image_type = $img_name[1];

        $img_name = $img_name[0] . uniqid() . "." . $image_type; // creates a random name for the image using uniqid()
        move_uploaded_file($image_file['tmp_name'], 'assets/img/sights/' . $img_name);

        $new_image = $img_name;
    } else {
        $new_image = $old_image;
    }


    $sights_dao->UpdateSightInfo($name, $canton, $adress, $description, $price, $is_validated, $is_requested, $is_showed, $new_image, $id_sights);
    header('location: ./index.php?page=admin_sights&message=info-changed');
} else if (isset($_POST['submit_delete_sight'])) { // if sight delete is submitted
    $sights_dao->DeleteSight($delete_sight_id);
    header('location: ./index.php?page=admin_sights&message=success-sight-deleted');
}
