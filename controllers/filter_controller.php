<?php
require_once './models/sightsDAO.php';

use SiteTemplate\models\SightsDAO;

$cantons = array('Genève', 'Fribourg', 'Vaud', 'Valais', 'Neuchâtel', 'Jura');
$cantons_count = count($cantons);

$categories = SightsDAO::GetCategories();
$categories_count = SightsDAO::CountCategories()[0];

$age_limits = SightsDAO::GetAgeLimits();
$age_limits_count = SightsDAO::CountAgeLimits()[0];

$budget = array('+ de 15CHF/pers.', '- de 15CHF/pers.', 'Gratuit');
$budget_count = count($budget);

//print_r($categories['name']);