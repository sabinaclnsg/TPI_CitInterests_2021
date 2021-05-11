<?php
require_once './models/userDAO.php';

use SiteTemplate\models\UserDAO;

$email = filter_input(INPUT_POST, 'email-forget-pwd', FILTER_SANITIZE_EMAIL);

$message = 'Bonjour';
$headers =  'MIME-Version: 1.0' . "\r\n"; 
$headers .= 'From: Your name <sitetemplate@gmail.com>' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 

if (isset($_POST['submit-forget-pwd'])) {
    if (UserDAO::EmailUsed($email)) { // check if email exists
        mail($email, "Mot de passe oublié", $message, $headers);
    } else {
        header('Location: index.php?message=error-email-forget-pwd&page=login');
    }
}
