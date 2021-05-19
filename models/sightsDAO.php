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

    public static function GetSights($limit, $offset)
    {
        $db = DBConnection::getConnection();

        // Prepare the paged query
        $request = $db->prepare('SELECT * FROM `sights` ORDER BY `name` LIMIT :limit OFFSET :offset');
        $request->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $request->bindParam(':offset', $offset, \PDO::PARAM_INT);
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

    public static function CreateSight($name, $price, $descripition, $adress, $canton, $telephone, $image, $user)
    {

        try {
            if (UserDAO::IsAdmin($_SESSION['connected_user_id'])) {
                $sql = "INSERT INTO sights (`name`,`price`,`description`, `adress`, `canton`, `telephone`, `image`, `validated`, `sights_delete_requested`, `id_user`)
    VALUES (:name, :price, :description, :adress, :canton, :telephone, :image, 1, 0, :user)";
            } else {
                $sql = "INSERT INTO sights (`name`,`price`,`description`, `adress`, `canton`, `telephone`, `image`, `validated`, `sights_delete_requested`, `id_user`)
        VALUES (:name, :price, :description, :adress, :canton, :telephone, :image, 0, 0, :user)";
            }

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':name' => $name,
                ':price' => $price,
                ':description' => $descripition,
                ':adress' => $adress,
                ':canton' => $canton,
                ':telephone' => $telephone,
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

    public static function UpdateSightInfo($name, $canton, $adress, $telephone, $description, $price, $validated, $sights_delete_requested, $showed, $img, $id)
    {
        try {
            $sql = "UPDATE sights SET name=:name, canton=:canton, adress=:adress, telephone=:telephone, description=:description, price=:price, validated=:validated, sights_delete_requested=:sights_delete_requested, sight_showed=:showed, image=:img WHERE id=:id";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':name' => $name,
                ':canton' => $canton,
                ':adress' => $adress,
                ':telephone' => $telephone,
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


    // filter functions
    public static function Filter($cantons_array, $categories_array, $ages_array, $budget_array)
    {
        try {
            $db = DBConnection::getConnection();
            $first_canton_or_budget = TRUE;
            $sql = 'SELECT a.* from sights as a ';

            if (!empty($categories_array)) { // if category array in parameter isn't empty, add query

                $first_on_list = TRUE;
                $sql .= 'INNER JOIN sights_contains_category as b ON ';

                foreach ($categories_array as $category) {
                    $category_id = SightsDAO::GetCategoryIdByName($category)[0];

                    if ($first_on_list == TRUE) {
                        $sql .= 'a.id=b.id_sights AND b.id_category=' . $category_id . ' ';
                    } else {
                        $sql .= 'OR a.id=b.id_sights AND b.id_category=' . $category_id . ' ';
                    }

                    $first_on_list = FALSE;
                }
            }
            if (!empty($ages_array)) { // if ages array in parameter isn't empty, add query

                $first_on_list = TRUE;
                $sql .= 'INNER JOIN sights_has_age_limit as c ON ';

                foreach ($ages_array as $age_limit) {
                    $age_limit_id = SightsDAO::GetAgeIdByName($age_limit)[0];

                    if ($first_on_list == TRUE) {
                        $sql .= 'a.id=c.id_sights AND c.id_age_limit=' . $age_limit_id . ' ';
                    } else {
                        $sql .= 'OR a.id=c.id_sights AND c.id_age_limit=' . $age_limit_id . ' ';
                    }

                    $first_on_list = FALSE;
                }
            }

            if (!empty($cantons_array)) {
                foreach ($cantons_array as $canton) {
                    if ($first_canton_or_budget == TRUE) {
                        $sql .= 'WHERE a.canton=\'' . $canton . '\' ';
                    } else {
                        $sql .= 'OR a.canton=\'' . $canton . '\' ';
                    }

                    $first_canton_or_budget = FALSE;
                }
            }
            if (!empty($budget_array)) {
                $first_on_list = TRUE;

                foreach ($budget_array as $budget) {
                    if (str_contains($budget, '+')) { // if budget is higher than 15
                        $budget_query = 'a.price>=15 ';
                    } else if (str_contains($budget, '-')) { // if budget is lower than 15
                        $budget_query = 'a.price<=15 ';
                    } else { // get all free sights
                        $budget_query = 'a.price=0 ';
                    }

                    if ($first_canton_or_budget == TRUE) {
                        $sql .= 'WHERE ' . $budget_query;
                    } else {
                        if ($first_on_list == TRUE) {
                            $sql .= 'AND ' . $budget_query;
                        } else {
                            $sql .= 'AND ' . $budget_query;
                        }
                    }

                    $first_canton_or_budget = FALSE;
                    $first_on_list = FALSE;
                }
            }

            $sql .= 'GROUP BY a.id';

            $request = $db->prepare($sql);
            $request->execute();
            return $request->fetchAll();
            //return $sql;
        } catch (mysqli_sql_exception $exception) {
            return "error";
        }
    }

    public static function FilterByCanton($canton)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT id FROM sights WHERE canton = :canton";

        $request = $db->prepare($sql);
        $request->execute([':canton' => $canton]);
        return $request->fetchAll();
    }

    public static function FilterByCategory($id_category)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT a.id_sights FROM sights_contains_category as a INNER JOIN sights as b ON a.id_category = :id_category";

        $request = $db->prepare($sql);
        $request->execute([':id_category' => $id_category]);
        return $request->fetchAll();
    }

    public static function GetCategoryIdByName($category_name)
    {
        try {
            $db = DBConnection::getConnection();
            $sql = "SELECT id FROM category WHERE name=:category_name";

            $request = $db->prepare($sql);
            $request->execute([':category_name' => $category_name]);
            return $request->fetch();
        } catch (mysqli_sql_exception $exception) {
            return 0;
        }
    }

    public static function SightHasCategory($id_category, $id_sights){
        try {
            $db = DBConnection::getConnection();
            $sql = "SELECT * FROM sights_contains_category WHERE id_category = :id_category AND id_sights = :id_sights";

            $request = $db->prepare($sql);
            $request->execute([':id_category' => $id_category, ':id_sights' => $id_sights]);
            if ($request->fetch() != 0) {
                return true;
            }else{
                return false;
            }
        } catch (mysqli_sql_exception $exception) {
            return false;
        }
    }

    public static function SightHasAgeLimit($id_age_limit, $id_sights){
        try {
            $db = DBConnection::getConnection();
            $sql = "SELECT * FROM sights_has_age_limit WHERE id_age_limit = :id_age_limit AND id_sights = :id_sights";

            $request = $db->prepare($sql);
            $request->execute([':id_age_limit' => $id_age_limit, ':id_sights' => $id_sights]);
            if ($request->fetch() != 0) {
                return true;
            }else{
                return false;
            }
        } catch (mysqli_sql_exception $exception) {
            return false;
        }
    }

    public static function DeleteSightsAgeLimits($id_sights){
        try {
            $sql = "DELETE FROM sights_has_age_limit WHERE id_sights=:id_sights";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':id_sights' => $id_sights,
            ]);
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    public static function DeleteSightsCategories($id_sights){
        try {
            $sql = "DELETE FROM sights_contains_category WHERE id_sights=:id_sights";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':id_sights' => $id_sights,
            ]);
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }


    public static function FilterByAge($id_age)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT a.id_sights FROM sights_has_age_limit as a INNER JOIN sights as b ON a.id_age_limit = :id_age";

        $request = $db->prepare($sql);
        $request->execute([':id_age' => $id_age]);
        return $request->fetchAll();
    }

    public static function FilterByBudget($budget)
    {
        $db = DBConnection::getConnection();

        if (str_contains($budget, '+')) { // if budget is higher than 15
            $sql = "SELECT id FROM sights WHERE price >= 15";
        } else if (str_contains($budget, '-')) { // if budget is lower than 15
            $sql = "SELECT id FROM sights WHERE price <= 15";
        } else { // if price is free
            $sql = "SELECT id FROM sights WHERE price = 0";
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
        $sql = "SELECT id FROM age_limit WHERE name = :age_name";

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
            $category_id = SightsDAO::GetCategoryIdByName($category_name)[0];
            $sql = "INSERT INTO sights_contains_category (`id_category`, `id_sights`) VALUES (:category_id, :id_sights)";

            $db = DBConnection::getConnection();
            $request = $db->prepare($sql);

            $request->execute([
                ':id_sights' => $id_sights,
                ':category_id' => $category_id,
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
    public static function Search($input)
    {
        try {
            $db = DBConnection::getConnection();
            $sql = "SELECT * FROM sights WHERE name LIKE '%$input%'";

            $request = $db->prepare($sql);
            $request->execute();
            return $request->fetchAll();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
