<?php
//session_destroy();
session_start();

// variable for redirecting
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
$message = filter_input(INPUT_GET, 'message', FILTER_SANITIZE_STRING);

if ($page == null) {
    header('location: ./index.php?page=homepage');
}

if (!isset($_SESSION['connected'])) {
    $_SESSION['connected'] = false;
    $_SESSION['connected_user_id'] = 0;
}

if (isset($page)) {

    if (isset($message)) { // for displaying error messages

        switch ($message) { // specifically called before page switch to avoid multiple refresh
            case 'success':
                $_SESSION['error-message'] = '<div class="alert alert-success" role="alert" name="alert">Vous êtes désormais inscrit.</div>';
                break;
            case 'error-case':
                $_SESSION['error-message'] = '<div class="alert alert-danger" role="alert" name="alert">Veuillez remplir toutes les cases.</div>';
                break;
            case 'error-pwd':
                $_SESSION['error-message'] = '<div class="alert alert-danger" role="alert" name="alert">Les mot de passes ne correspondent pas.</div>';
                break;
            case 'error-old-pwd':
                $_SESSION['error-message'] = '<div class="alert alert-danger" role="alert" name="alert">Ancien mot de passe incorrecte.</div>';
                break;
            case 'error-pwd-strength':
                $_SESSION['error-message'] = '<div class="alert alert-warning" role="alert" name="alert">Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial et faire 8 caractère ou plus!</div>';
                break;
            case 'error-email':
                $_SESSION['error-message'] = '<div class="alert alert-warning" role="alert" name="alert">Cet email a déjà été enregistré !</div>';
                break;
            case 'error-login':
                $_SESSION['error-message'] = '<div class="alert alert-danger" role="alert" name="alert">Vos informations de login ne sont pas correctes.</div>';
                break;
            case 'error-not-connected':
                $_SESSION['error-message'] = '<div class="alert alert-warning" role="alert" name="alert">Veuillez vous connecter.</div>';
                break;
            case 'logged':
                $_SESSION['error-message'] = '<div class="alert alert-success" role="alert" name="alert">Vous êtes connecté.</div>';
                break;
            case 'error-captcha':
                $_SESSION['error-message'] = '<div class="alert alert-danger" role="alert" name="alert">Merci de checker le Captcha.</div>';
                break;
            case 'error-email-forget-pwd':
                $_SESSION['error-message'] = '<div class="alert alert-danger" role="alert" name="alert">Cet email n\'existe pas.</div>';
                break;
            case 'password-changed':
                $_SESSION['error-message'] = '<div class="alert alert-success" role="alert" name="alert">Votre mot de passe a été changé.</div>';
                break;
            case 'info-changed':
                $_SESSION['error-message'] = '<div class="alert alert-success" role="alert" name="alert">Vos informations ont été enregistrées.</div>';
                break;
            case 'empty-icon':
                $_SESSION['error-message'] = '<div class="alert alert-warning" role="alert" name="alert">Veuillez choisir une photo.</div>';
                break;
            case 'success-proposition':
                $_SESSION['error-message'] = '<div class="alert alert-success" role="alert" name="alert">Votre proposition a été pris en compte.</div>';
                break;
            case 'success-user-deleted':
                $_SESSION['error-message'] = '<div class="alert alert-success" role="alert" name="alert">L\'utilisateur a été supprimé.</div>';
                break;
            case 'error_user_delete_existing_posts':
                $_SESSION['error-message'] = '<div class="alert alert-warning" role="alert" name="alert">L\'utilisateur ne peut pas être supprimé tant qu\'il a des centres d\'intérêts publiés.</div>';
                break;
            case 'success-user-posts-deleted':
                $_SESSION['error-message'] = '<div class="alert alert-success" role="alert" name="alert">Tous les publications de cet utilisateur ont été supprimés.</div>';
                break;
        }
    }

    switch ($page) {
        case 'homepage':
            require("homepage.php");
            break;
        case 'login':
            require("login.php");
            break;
        case 'logout':
            break;
        case 'register':
            require("register.php");
            break;
        case 'forget-password':
            require("forget_password.php");
            break;
        case 'create_sights':
            require("create_sights.php");
            break;
        case 'user':
            require("user.php");
            break;
        case 'admin':
            require("admin.php");
            break;
        case 'admin_users':
            require("admin_users.php");
            break;
    }
} else {
    require('homepage.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
</body>

</html>