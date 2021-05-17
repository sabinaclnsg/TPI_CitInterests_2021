<?php
require_once './models/userDAO.php';
require_once 'mailer_controller.php';

use CitInterests\models\UserDAO;
use CitInterests\mailer\Mailer;

if (!UserDAO::IsAdmin($_SESSION['connected_user_id'])) {
    header('location: index.php?page=login&message=error-not-connected');
}
$user_dao = new UserDAO();

foreach ($user_dao->GetUserSights(3) as $key) {
    var_dump($key['image']);
}

$count_users = $user_dao->CountUsers()[0];
$count_columns = $user_dao->CountColumns();
$column_names = $user_dao->GetColumnNames();
$users = $user_dao->GetUsers();
$column_names_fr = array('ID', 'Nom', 'Prénom', 'Email', 'Mot de passe', 'Statut', 'Admin', 'Banni', 'Image', 'Supprimer');

$id_user = filter_input(INPUT_POST, 'id_user', FILTER_SANITIZE_STRING);
$delete_user_id = filter_input(INPUT_POST, 'delete_user_id', FILTER_SANITIZE_STRING);

$lastname = filter_input(INPUT_POST, 'lastname_' . $id_user, FILTER_SANITIZE_STRING);
$firstname = filter_input(INPUT_POST, 'firstname_' . $id_user, FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email_' . $id_user, FILTER_SANITIZE_STRING);
$status = filter_input(INPUT_POST, 'status_' . $id_user, FILTER_SANITIZE_STRING);

$alert_message = 'info-changed';

if (isset($_POST['submit_modify_user'])) { // if modifications are submitted
    if ($user_dao->EmailUsed($email) && $email == $user_dao->GetUserEmail($id_user)[0] || !$user_dao->EmailUsed($email)) { // verifies if email input isnt already used and if the email doesnt belong to the user
        if (isset($_POST['is_admin_' . $id_user])) {
            $is_admin = 1;
        } else {
            $is_admin = 0;
        }

        if (isset($_POST['is_banned_' . $id_user])) {
            $is_banned = 1;
            if (!($user_dao->IsBanned($id_user))) { // sends an email if user wasn't already banned
                Mailer::SendMail('Bannissement sur CitInterests', '<p>Bonjour ' . $firstname . ' ' . $lastname . ',</p><br><p>Votre compte à été malheureusement banni. Raison du ban : spam.</p><br><br><p>CitInterests</p>', $email, $firstname, $lastname);
                $alert_message = 'user-banned';
            }
        } else {
            $is_banned = 0;
            if ($user_dao->IsBanned($id_user)) { // sends an unban email if user was already banned
                Mailer::SendMail('Debannissement sur CitInterests', '<p>Bonjour ' . $firstname . ' ' . $lastname . ',</p><br><p>Votre compte à été débanni. Re bonjour.</p><br><br><p>CitInterests</p>', $email, $firstname, $lastname);
                $alert_message = 'user-unbanned';
            }
        }

        if (isset($_POST['is_requested_' . $id_user])) {
            $is_requested = 1;
        } else {
            $is_requested = 0;
        }

        $user_dao->UpdateUserInfo($firstname, $lastname, $email, $status, $is_admin, $is_banned, $is_requested, $id_user);
        header('location: ./index.php?page=admin_users&message=' . $alert_message);
    } else {
        header('location: ./index.php?page=admin_users&message=error-email');
    }
} else if (isset($_POST['submit_delete_user'])) { // if user delete is submitted
    if ($user_dao->UserHasExistingPosts($delete_user_id)) { // checks if user has existing posts, user can't get deleted unless all posts are deleted
        header('location: ./index.php?page=admin_users&message=error_user_delete_existing_posts');
    } else {
        $user_dao->DeleteUser($delete_user_id);
        header('location: ./index.php?page=admin_users&message=success-user-deleted');
    }
} else if (isset($_POST['delete_all_posts'])) { // if delete all selected user's posts is submitted
    $user_dao->DeleteAllUserPosts($delete_user_id);
    header('location: ./index.php?page=admin_users&message=success-user-posts-deleted');
}
