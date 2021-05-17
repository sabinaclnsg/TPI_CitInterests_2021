<?php

namespace CitInterests\controllers;

if (isset($_GET['page'])) {
    require_once './models/sightsDAO.php';
}else{
    require_once '../models/sightsDAO.php';
}
use CitInterests\models\SightsDAO;

$cantons = array('Genève', 'Fribourg', 'Vaud', 'Valais', 'Neuchâtel', 'Jura');
$cantons_count = count($cantons);

$categories = SightsDAO::GetCategories();
$categories_count = SightsDAO::CountCategoriesAmount()[0];

$age_limits = SightsDAO::GetAgeLimits();
$age_limits_count = SightsDAO::CountAgeLimitsAmount()[0];

$budget = array('+ de 15CHF/pers.', '- de 15CHF/pers.', 'Gratuit');
$budget_count = count($budget);

class Filter
{
    public static function FilterSights($sight_show, $img_file_path, $status)
    {
        $sights_dao = new SightsDAO();
        $result = '';
        $result = "<div class=\"col-sm-12 col-md-6 col-lg-4 col-xl-3 my-3\">
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

return $result;
    }
}
