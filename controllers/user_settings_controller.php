<?php
require_once './models/userDAO.php';
require_once 'controllers/regex.php';

use CitInterests\models\UserDAO;

if ($_SESSION['connected'] != true) {
    header("Location: index.php?page=login&message=error-not-connected");
}

$user_dao = new UserDAO();

$id_user = $_SESSION['connected_user_id']; // get user id from session
$user_data = $user_dao->GetUserData_ParamId($_SESSION['connected_user_id']);

$old_firstname = $user_data[0]['firstname'];
$old_lastname = $user_data[0]['lastname'];
$old_email = $user_data[0]['email'];
$old_profile_icon = $user_data[0]['image'];

// post variables
$firstname = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
$lastname = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

$oldPwd = filter_input(INPUT_POST, 'old_pwd', FILTER_SANITIZE_STRING);
$newPwd = filter_input(INPUT_POST, 'new_pwd', FILTER_SANITIZE_STRING);
$newPwdConfirm = filter_input(INPUT_POST, 'new_pwd_confirm', FILTER_SANITIZE_STRING);

define("FILE_PATH", "./assets/img/profile_icon/");
$old_image = $user_data[0]['image'];

// change user icon
if (!empty($_FILES["icon_input"])) {
    if (isset($_FILES['icon_input'])) {
        $errorimg = $_FILES["icon_input"]["error"];

        if ($errorimg == UPLOAD_ERR_OK) {

            $tmp_name = $_FILES["icon_input"]["name"];
            $name = explode(".", $tmp_name);
            $name = $name[0] . uniqid() . "." . $name[1];
            move_uploaded_file($_FILES["icon_input"]["tmp_name"], FILE_PATH . $name);
            if (file_exists("assets/img/profile_icon/" . $old_image) && $old_image != 'profile-user-not-connected.svg') {
                unlink("assets/img/profile_icon/" . $old_image);
            }
            //ajout du nom du fichier dans la bd
            $user_dao->changePath($name, $tmp_name);
            $lienimg = FILE_PATH . $name;

            try {
                $user_dao->UpdateUserIcon($id_user, $name);
                header("Location: ./index.php?page=user-settings");
                exit();
            } catch (\Throwable $th) {
                $error = true;
            }
        }
    }
}

// if user submits modifications to user information
if (isset($_POST['submit-information'])) {
    if (!empty($firstname) && !empty($lastname) && !empty($email)) { // if all fields are filled

        $user_dao->UpdateMyInfo($firstname, $lastname, $email, $_SESSION['connected_user_id']); // update user information
        header('location: ./index.php?message=info-changed&page=user-settings'); // alert user
    } else {
        header('location: ./index.php?message=error-case&page=user-settings'); // error empty fields
    }
}

if (isset($_POST['submit-new-pwd'])) {
    if (!empty($oldPwd) && !empty($newPwd) && !empty($newPwdConfirm)) {
        $dbPassword = $user_dao->GetHashedPassword($user_data[0]['email']);

        if (password_verify($oldPwd, $dbPassword["password"])) { // checks if password submitted matches hashed password from database

            if (password_strength($newPwd)) { // checks if confirm password matches new password
                if ($newPwd == $newPwdConfirm) { // checks if password has at least 8 characters, an upper letter, lower letter, a number and a special character
                    $hashedPassword = password_hash($newPwd, PASSWORD_DEFAULT);
                    $user_dao->UpdateUserPassword($hashedPassword, $_SESSION['connected_user_id']); // change password

                    header('location: ./index.php?message=password-changed&page=user-settings');
                } else { // new password and confirm password dont match
                    header('location: ./index.php?message=error-pwd&page=user-settings');
                }
            } else { // password strength very low
                header('location: ./index.php?message=error-pwd-strength&page=user-settings');
            }
        } else { // old password doesnt match
            header('location: ./index.php?message=error-old-pwd&page=user-settings');
        }
    } else { // error empty fields
        header('location: ./index.php?message=error-case&page=user-settings');
    }
}
