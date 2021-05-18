<?php

require_once './models/userDAO.php';
require_once 'controllers/regex.php';

use CitInterests\models\UserDAO;

$user_dao = new UserDAO();

// post variables
$firstname = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_STRING);
$lastname = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$confirmPassword = filter_input(INPUT_POST, "confirm-password", FILTER_SANITIZE_STRING);
$hashedPassword = "";


if (isset($_POST['submit'])) { // if submit is clicked

    function post_captcha($user_response)
    {
        $fields_string = '';
        $fields = array(
            'secret' => '6Lc-Rs0aAAAAAKrj5nZdyUOsD_LBq4efkS8qLnYI',
            'response' => $user_response
        );
        foreach ($fields as $key => $value)
            $fields_string .= $key . '=' . $value . '&';
        $fields_string = rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    // Call the function post_captcha
    $res = post_captcha($_POST['g-recaptcha-response']);

    // if the captcha hasnt been checked
    if (!$res['success']) {
        header('Location: index.php?message=error-captcha&page=login');
    } else {

        if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password) && !empty($confirmPassword)) { // verifies if all inputs are filled

            if (!$user_dao->EmailUsed($email)) { // checks if the email submitted isn't already in use
                if (password_strength($password)) { // if password matches repeat password

                    if ($password == $confirmPassword) { // checks if password has at least 8 characters, an upper letter, lower letter, a number and a special character
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // hash and salt password
                        $user_dao->CreateUser($firstname, $lastname, $email, $hashedPassword); // create user using name, email and hashed pwd

                        header('location: ./index.php?message=success&page=login'); // redirect to login page with success message
                    } else { // passwords dont match
                        header('location: ./index.php?message=error-pwd&page=register');
                    }
                } else { // password strength very low
                    header('location: ./index.php?message=error-pwd-strength&page=register');
                }
            } else if ($user_dao->EmailUsed($email) && $user_dao->IsArchived($email)) { // checks if email is in use and if user is archived
                $dbPassword = $user_dao->GetHashedPassword($email); // gets hashed password using submitted email
                if ($password == $confirmPassword) { // checks if password has at least 8 characters, an upper letter, lower letter, a number and a special character
                    if (password_verify($password, $dbPassword["password"])) { // checks if password submitted matches hashed password from database
                        $user_dao->ActivateUser($email); // activate archived user's account
                        header('Location: index.php?message=user-activated&page=login');
                    } else {
                        header('Location: index.php?message=error-login&page=register');
                    }
                } else { // passwords dont match
                    header('location: ./index.php?message=error-pwd&page=register');
                }
            } else { // email already in use but isn't archived
                header('location: ./index.php?message=error-email&page=register');
            }
        } else { // not all inputs are filled
            header('location: ./index.php?message=error-case&page=register'); // redirect to register page with error msg
        }
    }
}
