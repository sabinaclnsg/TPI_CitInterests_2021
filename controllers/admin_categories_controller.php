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

$categories_count = $sights_dao->CountCategoriesAmount()[0];
$age_limits_count = $sights_dao->CountAgeLimitsAmount()[0];

$count_sights = $sights_dao->CountSights()[0];
$count_columns = $sights_dao->CountColumns();
$column_names = $sights_dao->GetColumnNames();
$column_names_fr = array('ID', 'Nom', 'Canton', 'Adresse', 'Description', 'Prix', 'Image', 'Valider', 'Supprimer', 'Afficher', 'ID utilisateur');
$sights = $sights_dao->GetSights();

$age_limits = $sights_dao->GetAgeLimits();
$categories = $sights_dao->GetCategories();