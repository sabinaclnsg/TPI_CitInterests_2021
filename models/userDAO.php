<?php

namespace CitInterests\models;

use CitInterests\models\DBConnection;
use mysqli_sql_exception;
use PDO;

require_once 'dbConnection.php';

class UserDAO
{
    // -- GET --
    public static function GetUsers()
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT * FROM user";

        $request = $db->prepare($sql);
        $request->execute();
        return $request->fetchAll();
    }

    public static function CountUsers()
    {
        $db = DBConnection::getConnection();
        $request = $db->query('SELECT count(*) from user');

        $request->execute();
        return $request->fetch();
    }

    public static function GetUserId_ParamEmail($email)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT id FROM user WHERE email = :email";

        $request = $db->prepare($sql);
        $request->execute([':email' => $email]);
        return $request->fetch();
    }

    public static function GetUserData_ParamId($id)
    {
        try {
            $sql = "SELECT * FROM user WHERE id = :id";
            $db = DBConnection::getConnection();

            $request = $db->prepare($sql);
            $request->execute([':id' => $id]);
            return $request->fetchAll();
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    public static function GetUserEmail($id_user)
    {
        try {
            $sql = "SELECT email FROM user WHERE id = :id_user";
            $db = DBConnection::getConnection();

            $request = $db->prepare($sql);
            $request->execute([':id_user' => $id_user]);
            return $request->fetch();
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    public static function GetUserImage($id_user)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT image FROM user WHERE id = :id_user";

        $request = $db->prepare($sql);
        $request->execute([':id_user' => $id_user]);
        return $request->fetch();
    }

    public static function GetUserSights($id_user)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT * FROM sights WHERE id_user = :id_user";

        $request = $db->prepare($sql);
        $request->execute([':id_user' => $id_user]);
        return $request->fetchAll();
    }

    public static function GetColumnNames()
    {
        $db = DBConnection::getConnection();
        $sql = "DESCRIBE user";

        $request = $db->prepare($sql);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function CountColumns()
    {
        $db = DBConnection::getConnection();
        $request = $db->query('SELECT * from user');

        $request->execute();
        return $request->columnCount();
    }


    // ----------
    // -- CRUD --
    public static function CreateUser($firstname, $lastname, $email, $password)
    {
        try {
            $sql = "INSERT INTO user (`firstname`,`lastname`,`email`, `password`, `image`)
    VALUES (:firstname, :lastname, :email, :password, 'profile-user-not-connected.svg')";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':email' => $email,
                ':password' => $password,
            ]);
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    public static function UpdateUserInfo($firstname, $lastname, $email, $status, $admin, $banned, $account_delete_requested, $id)
    {
        try {
            $sql = "UPDATE user SET firstname=:firstname, lastname=:lastname, email=:email, status=:status, admin=:admin, banned=:banned, account_delete_requested=:account_delete_requested WHERE id=:id";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':email' => $email,
                ':status' => $status,
                ':admin' => $admin,
                ':banned' => $banned,
                ':account_delete_requested' => $account_delete_requested,
                ':id' => $id,
            ]);
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    public static function UpdateUserPassword($password, $id)
    {
        try {
            $sql = "UPDATE user SET password=:password WHERE id=:id";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':password' => $password,
                ':id' => $id,
            ]);
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    public static function UpdateUserIcon($id_user, $profile_icon)
    {
        try {
            $db = DBConnection::getConnection();
            $sql = "UPDATE `user` SET `profileImg` = :profle_icon WHERE `id` = :id_user";
            $request = $db->prepare($sql);
            $request->execute([':id_user' => $id_user, ':profle_icon' => $profile_icon]);
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    public static function ActivateUser($email)
    {
        try {
            $db = DBConnection::getConnection();
            $sql = "UPDATE `user` SET `status` = 'active' WHERE `email` = :email";
            $request = $db->prepare($sql);
            $request->execute([':email' => $email]);
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    public static function ForgetPassword($email, $new_password)
    {
        try {
            $sql = "UPDATE user SET password=:new_password WHERE email=:email";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':email' => $email,
                ':new_password' => $new_password,
            ]);
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    public static function DeleteUser($id_user)
    {
        try {
            $sql = "DELETE FROM user WHERE id=:id_user";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            if (UserDAO::GetUserImage($id_user)[0] != 'profile-user-not-connected.svg') {
                unlink('assets/img/profile_icon/' . UserDAO::GetUserImage($id_user)[0]);
            }

            $request->execute([
                ':id_user' => $id_user,
            ]);
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    public static function DeleteAllUserPosts($id_user)
    {
        try {
            foreach (UserDAO::GetUserSights($id_user) as $to_delete) {
                unlink('assets/img/sights/' . $to_delete['image']);
            }

            $sql = "DELETE FROM sights WHERE id_user=:id_user";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':id_user' => $id_user,
            ]);

        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    // -----------
    // -- OTHER --
    public static function GetHashedPassword($email)
    {
        try {
            $sql = "SELECT password FROM user WHERE `email` = :email";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':email' => $email,
            ]);

            return $request->fetch();
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    // check if submitted email is used
    // returns true or false
    public static function EmailUsed($email)
    {
        try {
            $sql = "SELECT * FROM user WHERE email = :email";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':email' => $email,
            ]);

            // get the number of rows
            $number_of_rows = $request->fetchColumn();

            if ($number_of_rows > 0) { // if result returns more than 0 values, return true
                return true;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    // verifies if user was already banned before hand
    // this function prevents the email notification from sending everytime a banned user's information is modified
    // return true or false
    public static function IsBanned($id_user)
    {
        try {
            $sql = "SELECT banned FROM user WHERE id = :id_user";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':id_user' => $id_user,
            ]);

            // get admin bool
            $is_banned = $request->fetchColumn();

            if ($is_banned == '0') { // if result returns false, return false
                return false;
            } else {
                return true;
            }
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    // verifies if user was already banned before hand
    // return true or false
    public static function IsArchived($email)
    {
        try {
            $sql = "SELECT status FROM user WHERE email = :email";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':email' => $email,
            ]);

            // get admin bool
            $is_archived = $request->fetchColumn();

            if ($is_archived == 'archived') { // if result returns false, return false
                return true;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    // check if user connected is an admin
    // returns true or false
    public static function IsAdmin($id)
    {
        try {
            $sql = "SELECT admin FROM user WHERE id = :id";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':id' => $id,
            ]);

            // get admin bool
            $is_admin = $request->fetchColumn();

            if ($is_admin == '0') { // if result returns false, return false
                return false;
            } else {
                return true;
            }
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    public static function changePath($name, $tempname)
    {
        try {
            $db = DBConnection::getConnection();
            $sql = "UPDATE `user` SET `profileImg` = :named WHERE `profileImg` = :tempname";

            $q = $db->prepare($sql);
            $q->execute(array(
                ':named' => $name,
                ':tempname' => substr($tempname, 0, 2)
            ));
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    // check if user has existing posts
    // returns true or false
    public static function UserHasExistingPosts($id_user)
    {
        $db = DBConnection::getConnection();
        $request = $db->query("SELECT count(*) from sights WHERE id_user = $id_user");

        $request->execute();

        if ($request->fetchColumn() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
