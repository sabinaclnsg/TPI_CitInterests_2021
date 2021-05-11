<?php

namespace SiteTemplate\models;
require_once './models/userDAO.php';

use SiteTemplate\models\DBConnection;
use SiteTemplate\models\UserDAO;
use mysqli_sql_exception;
use PDO;

require_once 'dbConnection.php';

class SightsDAO
{
    public static function GetColumnNames($table)
    {
        $db = DBConnection::getConnection();
        $sql = "SHOW `columns` FROM :table";

        $request = $db->prepare($sql);
        $request->execute([':table' => $table]);
        return $request->fetchAll();
    }

    public static function GetEnumValues($table, $column)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT column_type FROM information_schema.columns WHERE table_name = :table AND column_name = :column";

        $request = $db->prepare($sql);
        $request->execute([':table' => $table, ':column' => $column]);
        return $request->fetch();
    }

    public static function CountValidatedSights()
    {
        $db = DBConnection::getConnection();
        $request = $db->query('SELECT count(*) from sights WHERE validated = 1');

        $request->execute();
        return $request->fetch();
    }

    public static function GetValidatedSights()
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT * FROM sights WHERE validated = 1";

        $request = $db->prepare($sql);
        $request->execute();
        return $request->fetchAll();
    }

    public static function SightsIsValidated($id_sights)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT validated FROM sights WHERE id = :id_sights";

        $request = $db->prepare($sql);
        $request->execute([':id_sights' => $id_sights]);
        
        if ($request->fetch(PDO::FETCH_ASSOC)['validated'] == '1') {
            return true;
        }else{
            return false;
        }
    }

    public static function GetUserOfSights($id_sights)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT user.* FROM user INNER JOIN sights ON sights.id = :id_sights AND user.id = sights.id_user";

        $request = $db->prepare($sql);
        $request->execute([':id_sights' => $id_sights]);
        return $request->fetchAll();
    }

    public static function CreateSight($name, $price, $descripition, $adress, $canton, $image, $user)
    {
        if (UserDAO::IsAdmin($_SESSION['connected_user_id'])) { // if user that posted is an admin, sights is directly validated
            $validated = 1;
        }else{
            $validated = 0;
        }

        try {
            $sql = "INSERT INTO sights (`name`,`price`,`description`, `adress`, `canton`, `image`, `validated`, `sights_delete_requested`, `id_user`)
    VALUES (:name, :price, :description, :adress, :canton, :image, $validated, 0, :user)";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':name' => $name,
                ':price' => $price,
                ':description' => $descripition,
                ':adress' => $adress,
                ':canton' => $canton,
                ':image' => $image,
                ':user' => $user,
            ]);

            return $db->lastInsertId();
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    public static function CreateOpeningHours($monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday, $id_sights)
    {
        try {
            $sql = "INSERT INTO opening_hours (`monday`,`tuesday`,`wednesday`, `thursday`, `friday`, `saturday`, `sunday`, `id_sights`)
    VALUES (:monday, :tuesday, :wednesday, :thursday, :friday, :saturday, :sunday, :id_sights)";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':monday' => $monday,
                ':tuesday' => $tuesday,
                ':wednesday' => $wednesday,
                ':thursday' => $thursday,
                ':friday' => $friday,
                ':saturday' => $saturday,
                ':sunday' => $sunday,
                ':id_sights' => $id_sights,
            ]);
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    public static function CreateClosingHours($monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday, $id_sights)
    {
        try {
            $sql = "INSERT INTO closing_hours (`monday`,`tuesday`,`wednesday`, `thursday`, `friday`, `saturday`, `sunday`, `id_sights`)
    VALUES (:monday, :tuesday, :wednesday, :thursday, :friday, :saturday, :sunday, :id_sights)";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':monday' => $monday,
                ':tuesday' => $tuesday,
                ':wednesday' => $wednesday,
                ':thursday' => $thursday,
                ':friday' => $friday,
                ':saturday' => $saturday,
                ':sunday' => $sunday,
                ':id_sights' => $id_sights,
            ]);
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }


    // filter functions
    public static function GetCategories()
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT * FROM category";

        $request = $db->prepare($sql);
        $request->execute();
        return $request->fetchAll();
    }

    public static function GetCategory($offset = null, $limit = null, $category = null)
    {
        $db = DBConnection::getConnection();

        if ($category == NULL) {
            $sql = "SELECT * FROM category";
        } else {
            $sql = "SELECT * FROM category WHERE name = $category";
        }

        $request = $db->prepare($sql);
        $request->execute();
        return $request->fetchAll();
    }

    public static function CountCategories()
    {
        $db = DBConnection::getConnection();
        $request = $db->query('SELECT count(*) from category');

        $request->execute();
        return $request->fetch();
    }

    public static function LinkCategoryToSights($category_name, $id_sights)
    {
        try {
            $sql = "INSERT INTO sights_contains_category (`id_category`, `id_sights`) 
            SELECT id, :id_sights
            FROM category WHERE name = :category_name";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':category_name' => $category_name,
                ':id_sights' => $id_sights,
            ]);
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    public static function GetAgeLimits()
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT * FROM age_limit";

        $request = $db->prepare($sql);
        $request->execute();
        return $request->fetchAll();
    }

    public static function CountAgeLimits()
    {
        $db = DBConnection::getConnection();
        $request = $db->query('SELECT count(*) from age_limit');

        $request->execute();
        return $request->fetch();
    }

    public static function LinkAgeLimitToSights($id_age_limit, $id_sights)
    {
        try {
            $sql = "INSERT INTO sights_has_age_limit (`id_age_limit`, `id_sights`) 
            SELECT id, :id_sights
            FROM age_limit WHERE name = :id_age_limit";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':id_age_limit' => $id_age_limit,
                ':id_sights' => $id_sights,
            ]);
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    public static function GetOpeningHourByDay($day, $id_sights)
    {
        try {
            $db = DBConnection::getConnection();
            $sql = "SELECT $day FROM opening_hours WHERE id_sights = :id_sights";

            $request = $db->prepare($sql);
            $request->execute([
                ':id_sights' => $id_sights,
            ]);
            return $request->fetch();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function GetClosingHourByDay($day, $id_sights)
    {
        try {
            $db = DBConnection::getConnection();
            $sql = "SELECT $day FROM closing_hours WHERE id_sights = :id_sights";

            $request = $db->prepare($sql);
            $request->execute([
                ':id_sights' => $id_sights,
            ]);
            return $request->fetch();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function IsOpen24h($id_sights)
    {
        try {
            $db = DBConnection::getConnection();
            $sql = "SELECT o.monday, o.tuesday, o.wednesday, o.thursday, o.friday, o.saturday, c.sunday, c.monday, c.tuesday, c.wednesday, c.thursday, c.friday, c.saturday, c.sunday 
            FROM opening_hours as o
            INNER JOIN closing_hours as c
            ON o.id_sights = :id_sights AND c.id_sights = o.id_sights";

            $request = $db->prepare($sql);
            $request->execute([
                ':id_sights' => $id_sights,
            ]);

            $output = $request->fetch();

            // array_unique combines all array indentic array values in one index
            // this verifies if all values are = '00:00'
            if (count(array_unique($output)) === 1) {
                return true;
            }else{
                return false;
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
