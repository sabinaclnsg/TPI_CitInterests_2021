<?php
require_once './models/userDAO.php';

use CitInterests\models\UserDAO;

$user_dao = new UserDAO();

// login
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

// verifies captcha
if (isset($_POST['submit'])) {
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

        if (isset($_POST['submit'])) { // if login has been submitted

            if (!empty($email) && !empty($password)) { // if email and password inputs arent empty
                if ($user_dao->IsArchived($email)) { // if user is archived, redirect to register page
                    header('location: ./index.php?message=error-archived-user&page=register'); // user archived

                } else {
                    $dbPassword = $user_dao->GetHashedPassword($email); // gets hashed password using submitted email

                    if (password_verify($password, $dbPassword["password"])) { // checks if password submitted matches hashed password from database
                        // sets user as connected
                        $_SESSION['connected'] = true;
                        $_SESSION['connected_user_id'] = $user_dao->GetUserId_ParamEmail($email)['id'];
                        header('Location: index.php?message=logged&page=homepage');
                    } else {
                        header('Location: index.php?message=error-login&page=login');
                    }
                }
            }
        }
    }
}
