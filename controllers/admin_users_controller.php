<?php
require_once './models/userDAO.php';

use SiteTemplate\models\UserDAO;

if (!UserDAO::IsAdmin($_SESSION['connected_user_id'])) {
    header('location: index.php?page=login&message=error-not-connected');
}

$count_users = UserDAO::CountUsers()[0];
$count_columns = UserDAO::CountColumns();
$column_names = UserDAO::GetColumnNames();
$users = UserDAO::GetUsers();

$id_user = filter_input(INPUT_POST, 'id_user', FILTER_SANITIZE_STRING);
$delete_user_id = filter_input(INPUT_POST, 'delete_user_id', FILTER_SANITIZE_STRING);

$lastname = filter_input(INPUT_POST, 'lastname_' . $id_user, FILTER_SANITIZE_STRING);
$firstname = filter_input(INPUT_POST, 'firstname_' . $id_user, FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email_' . $id_user, FILTER_SANITIZE_STRING);
$status = filter_input(INPUT_POST, 'status_' . $id_user, FILTER_SANITIZE_STRING);
var_dump(UserDAO::GetUserEmail(9)[0]);
var_dump($email == UserDAO::GetUserEmail($id_user));

if (isset($_POST['submit_modify_user'])) { // if modifications are submitted
    if (UserDAO::EmailUsed($email) && $email == UserDAO::GetUserEmail($id_user)[0] || !UserDAO::EmailUsed($email)) { // verifies if email input isnt already used and if the email doesnt belong to the user
        if (isset($_POST['is_admin_' . $id_user])) {
            $is_admin = 1;
        } else {
            $is_admin = 0;
        }

        if (isset($_POST['is_banned_' . $id_user])) {
            $is_banned = 1;
        } else {
            $is_banned = 0;
        }

        if (isset($_POST['is_requested_' . $id_user])) {
            $is_requested = 1;
        } else {
            $is_requested = 0;
        }

        UserDAO::UpdateUserInfo($firstname, $lastname, $email, $status, $is_admin, $is_banned, $is_requested, $id_user);
        header('location: ./index.php?page=admin_users&message=info-changed');
    }else{
        header('location: ./index.php?page=admin_users&message=error-email');
    }
} else if (isset($_POST['submit_delete_user'])) { // if user delete is submitted
    if (UserDAO::UserHasExistingPosts($delete_user_id)) { // checks if user has existing posts, user can't get deleted unless all posts are deleted
        header('location: ./index.php?page=admin_users&message=error_user_delete_existing_posts');
    } else {
        UserDAO::DeleteUser($delete_user_id);
        header('location: ./index.php?page=admin_users&message=success-user-deleted');
    }
} else if (isset($_POST['delete_all_posts'])) { // if delete all selected user's posts is submitted
    UserDAO::DeleteAllUserPosts($delete_user_id);
    header('location: ./index.php?page=admin_users&message=success-user-posts-deleted');
}
