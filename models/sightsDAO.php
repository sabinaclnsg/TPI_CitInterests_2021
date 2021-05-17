<?php

namespace CitInterests\models;

use CitInterests\models\DBConnection;
use mysqli_sql_exception;
use PDO;

require_once 'dbConnection.php';

class SightsDAO
{
    public static function GetColumnNames()
    {
        $db = DBConnection::getConnection();
        $sql = "DESCRIBE sights";

        $request = $db->prepare($sql);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function GetEnumValues($table, $column)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT column_type FROM information_schema.columns WHERE table_name = :table AND column_name = :column";

        $request = $db->prepare($sql);
        $request->execute([':table' => $table, ':column' => $column]);
        return $request->fetch();
    }

    public static function CountValidatedSightsAmount()
    {
        $db = DBConnection::getConnection();
        $request = $db->query('SELECT count(*) from sights WHERE validated = 1');

        $request->execute();
        return $request->fetch();
    }

    public static function CountSights()
    {
        $db = DBConnection::getConnection();
        $request = $db->query('SELECT count(*) from sights');

        $request->execute();
        return $request->fetch();
    }

    public static function CountColumns()
    {
        $db = DBConnection::getConnection();
        $request = $db->query('SELECT * from sights');

        $request->execute();
        return $request->columnCount();
    }

    public static function GetValidatedSights()
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT * FROM sights WHERE validated = 1";

        $request = $db->prepare($sql);
        $request->execute();
        return $request->fetchAll();
    }

    public static function GetSights()
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT * FROM sights";

        $request = $db->prepare($sql);
        $request->execute();
        return $request->fetchAll();
    }

    public static function GetSightImage($id_sights)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT image FROM sights WHERE id = :id_sights";

        $request = $db->prepare($sql);
        $request->execute([':id_sights' => $id_sights]);
        return $request->fetch();
    }

    public static function GetSightById($id_sights)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT * FROM sights WHERE id = :id_sights";

        $request = $db->prepare($sql);
        $request->execute([':id_sights' => $id_sights]);
        return $request->fetch();
    }

    public static function GetShowedSights()
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT * FROM sights WHERE sight_showed = 1";

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
        } else {
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

        try {
            if (UserDAO::IsAdmin($_SESSION['connected_user_id'])) {
                $sql = "INSERT INTO sights (`name`,`price`,`description`, `adress`, `canton`, `image`, `validated`, `sights_delete_requested`, `id_user`)
    VALUES (:name, :price, :description, :adress, :canton, :image, 1, 0, :user)";
            } else {
                $sql = "INSERT INTO sights (`name`,`price`,`description`, `adress`, `canton`, `image`, `validated`, `sights_delete_requested`, `id_user`)
        VALUES (:name, :price, :description, :adress, :canton, :image, 0, 0, :user)";
            }

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

    public static function DeleteSight($id_sights)
    {
        try {
            $sql = "DELETE FROM sights WHERE id=:id_sights";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            unlink('assets/img/sights/' . UserDAO::GetUserImage($id_sights)[0]);

            $request->execute([
                ':id_sights' => $id_sights,
            ]);
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    public static function UpdateSightInfo($name, $canton, $adress, $description, $price, $validated, $sights_delete_requested, $showed, $img, $id)
    {
        try {
            $sql = "UPDATE sights SET name=:name, canton=:canton, adress=:adress, description=:description, price=:price, validated=:validated, sights_delete_requested=:sights_delete_requested, sight_showed=:showed, image=:img WHERE id=:id";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':name' => $name,
                ':canton' => $canton,
                ':adress' => $adress,
                ':description' => $description,
                ':price' => $price,
                ':validated' => $validated,
                ':sights_delete_requested' => $sights_delete_requested,
                ':showed' => $showed,
                ':img' => $img,
                ':id' => $id,
            ]);
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    public static function UpdateSightShow($id_sights)
    {
        try {
            // sight needs to be validated before showing
            $sql = "UPDATE sights SET sight_showed=1 WHERE id=:id_sights AND validated = 1";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':id_sights' => $id_sights,
            ]);
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    public static function ResetSightShow()
    {
        try {
            $sql = "UPDATE sights SET sight_showed=0";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute();
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }


    // filter functions
    public static function FilterByCanton($canton)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT id FROM sights WHERE canton = :canton AND sight_showed = 1";

        $request = $db->prepare($sql);
        $request->execute([':canton' => $canton]);
        return $request->fetchAll();
    }

    public static function FilterByCategory($id_category)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT a.id_sights FROM sights_contains_category as a INNER JOIN sights as b ON a.id_category = :id_category AND b.sight_showed = 1";

        $request = $db->prepare($sql);
        $request->execute([':id_category' => $id_category]);
        return $request->fetchAll();
    }

    public static function GetCategoryIdByName($category_name)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT a.id FROM category as a INNER JOIN sights as b ON a.name = :category_name AND b.sight_showed = 1";

        $request = $db->prepare($sql);
        $request->execute([':category_name' => $category_name]);
        return $request->fetch();
    }

    public static function FilterByAge($id_age)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT a.id_sights FROM sights_has_age_limit as a INNER JOIN sights as b ON a.id_age_limit = :id_age AND b.sight_showed = 1";

        $request = $db->prepare($sql);
        $request->execute([':id_age' => $id_age]);
        return $request->fetchAll();
    }

    public static function FilterByBudget($budget)
    {
        $db = DBConnection::getConnection();

        if ($budget == "+ de 15CHF/pers.") { // if budget is higher than 15
            $sql = "SELECT id FROM sights WHERE price >= 15 AND sight_showed = 1";
        } else if ($budget == "- de 15CHF/pers.") { // if budget is lower than 15
            $sql = "SELECT id FROM sights WHERE price <= 15 AND sight_showed = 1";
        } else if ($budget == "Gratuit") { // if price is free
            $sql = "SELECT id FROM sights WHERE price = 0 AND sight_showed = 1";
        } else {
            return false;
        }

        $request = $db->prepare($sql);
        $request->execute();
        return $request->fetchAll();
    }

    public static function GetSightAge($id_sights)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT a.name FROM age_limit as a INNER JOIN sights_has_age_limit as b ON b.id_sights = :id_sights AND a.id = b.id_age_limit";

        $request = $db->prepare($sql);
        $request->execute([':id_sights' => $id_sights]);
        return $request->fetchAll();
    }

    public static function GetSightCategory($id_sights)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT a.name FROM category as a INNER JOIN sights_contains_category as b ON b.id_sights = :id_sights AND a.id = b.id_category";

        $request = $db->prepare($sql);
        $request->execute([':id_sights' => $id_sights]);
        return $request->fetchAll();
    }

    public static function GetAgeIdByName($age_name)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT a.id FROM age_limit as a INNER JOIN sights as b ON a.name = :age_name AND b.sight_showed = 1";

        $request = $db->prepare($sql);
        $request->execute([':age_name' => $age_name]);
        return $request->fetch();
    }

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

    public static function CountCategoriesAmount()
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

    public static function CountAgeLimitsAmount()
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
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // Search Bar
    public static function Search($input){
        try {
            $db = DBConnection::getConnection();
            $sql = "UPDATE sights SET sight_showed=1 WHERE name LIKE '%$input%'";

            $request = $db->prepare($sql);
            $request->execute();
            return $request->fetchAll();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
