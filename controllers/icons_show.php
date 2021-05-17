<?php

// icons for ages
if (isset($age_limit)) {
    switch ($age_limit) {
        case '0-4':
            $age_icon = '<i class=\'fas fa-baby\'></i>';
            break;
        case '5-7':
            $age_icon = '<i class=\'fas fa-child\'></i>';
            break;
        case '7-12':
            $age_icon = '<i class=\'fas fa-child\'></i>';
            break;
        case 'Adolescents':
            $age_icon = '<i class=\'fas fa-male\'></i>';
            break;
        case 'Adultes':
            $age_icon = '<i class=\'fas fa-user-tie\'></i>';
            break;
        default:
            $age_icon = '<i class=\'fas fa-male\'></i>';
            break;
    }
}

// icons for categories
if (isset($category)) {
    switch ($category) {
        case 'Activité':
            $category_icon = '<i class=\'fas fa-running\' style=\'height:50px\'></i>';
            break;
        case 'Station de montagne':
            $category_icon = '<i class=\'fas fa-mountain\'></i>';
            break;
        case 'Balade':
            $category_icon = '<i class=\'fas fa-hiking\'></i>';
            break;
        case 'Place de pique-nique':
            $category_icon = '<i class=\'fas fa-shopping-basket\'></i>';
            break;
        case 'Idée week-end':
            $category_icon = '<i class=\'fas fa-sun\'></i>';
            break;
        case 'Place de jeu':
            $category_icon = '<i class=\'fas fa-dice\'></i>';
            break;

        default:
        $category_icon = '<i class=\'fas fa-running\'></i>';
            break;
    }
}
