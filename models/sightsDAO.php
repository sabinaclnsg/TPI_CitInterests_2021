<?php

namespace CitInterests\models;

use CitInterests\models\DBConnection;
use mysqli_sql_exception;
use PDO;

require_once 'dbConnection.php';

class SightsDAO
{
    /* -- GET SIGHTS -- */

    // get all validated sights
    // returns array of data
    public static function GetValidatedSights()
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT * FROM sights WHERE validated = 1";

        $request = $db->prepare($sql);
        $request->execute();
        return $request->fetchAll();
    }

    // get all sights, useful for admin page
    // parameter(s) : limit offset
    // returns array of data
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

    // get a sight's image
    // parameter(s) : id_sights
    // returns image
    public static function GetSightImage($id_sights)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT image FROM sights WHERE id = :id_sights";

        $request = $db->prepare($sql);
        $request->execute([':id_sights' => $id_sights]);
        return $request->fetch();
    }

    // get a sight's information
    // parameter(s) : id_sights
    // returns array of data
    public static function GetSightById($id_sights)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT * FROM sights WHERE id = :id_sights";

        $request = $db->prepare($sql);
        $request->execute([':id_sights' => $id_sights]);
        return $request->fetch();
    }

    // get the user of a sight
    // parameter(s) : id_sights
    // returns array of data (user's data)
    public static function GetUserOfSights($id_sights)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT user.* FROM user INNER JOIN sights ON sights.id = :id_sights AND user.id = sights.id_user";

        $request = $db->prepare($sql);
        $request->execute([':id_sights' => $id_sights]);
        return $request->fetchAll();
    }

    // get all column names from sights table
    // returns array of data
    public static function GetColumnNames()
    {
        $db = DBConnection::getConnection();
        $sql = "DESCRIBE sights";

        $request = $db->prepare($sql);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_COLUMN);
    }

    // count all validated sights
    // returns count sum
    public static function CountValidatedSightsAmount()
    {
        $db = DBConnection::getConnection();
        $request = $db->query('SELECT count(*) from sights WHERE validated = 1');

        $request->execute();
        return $request->fetch();
    }

    // count all sights
    // returns array of data
    public static function CountSights()
    {
        $db = DBConnection::getConnection();
        $request = $db->query('SELECT count(*) from sights');

        $request->execute();
        return $request->fetch();
    }

    // count all column names from sights table
    // returns count sum
    public static function CountColumns()
    {
        $db = DBConnection::getConnection();
        $request = $db->query('SELECT * from sights');

        $request->execute();
        return $request->columnCount();
    }


    // get the opening hour of a sight by input day
    // parameter(s) : day, id_sights
    // returns opening hours
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

    // get the closing hour of a sight by input day
    // parameter(s) : day, id_sights
    // returns closing hours
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

    // checks if a sight is open 24/7
    // parameter(s) : id_sights
    // returns true or false
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

    /* -- CREATE SIGHT -- */

    // create a sight
    // parameter(s) : name, price, description, adress, canton, telephone, image, user
    // returns nothing
    public static function CreateSight($name, $price, $descripition, $adress, $canton, $telephone, $image, $user_id)
    {
        try {
            if (UserDAO::IsAdmin($_SESSION['connected_user_id'])) {
                $sql = "INSERT INTO sights (`name`,`price`,`description`, `adress`, `canton`, `telephone`, `image`, `validated`, `sights_delete_requested`, `id_user`)
    VALUES (:name, :price, :description, :adress, :canton, :telephone, :image, 1, 0, :user_id)";
            } else {
                $sql = "INSERT INTO sights (`name`,`price`,`description`, `adress`, `canton`, `telephone`, `image`, `validated`, `sights_delete_requested`, `id_user`)
        VALUES (:name, :price, :description, :adress, :canton, :telephone, :image, 0, 0, :user_id)";
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
                ':user_id' => $user_id,
            ]);

            return $db->lastInsertId();
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }

    // creates opening hours for a sight and links them
    // parameter(s) : monday, tuesday, wednesday, thursday, friday, saturday, sunday, id_sights
    // returns nothing
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

    // creates closing hours for a sight and links them
    // parameter(s) : monday, tuesday, wednesday, thursday, friday, saturday, sunday, id_sights
    // returns nothing
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

    /* -- DELETE SIGHT -- */

    // delete a sight
    // parameter(s) : id_sights
    // returns nothing
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

    /* -- UPDATE SIGHT --*/

    // update a sight's informations
    // parameter(s) : name, canton , adress, telephone, description, price, validated, sights_delete_requested, img, id
    // returns nothing
    public static function UpdateSightInfo($name, $canton, $adress, $telephone, $description, $price, $validated, $sights_delete_requested, $img, $id)
    {
        try {
            $sql = "UPDATE sights SET name=:name, canton=:canton, adress=:adress, telephone=:telephone, description=:description, price=:price, validated=:validated, sights_delete_requested=:sights_delete_requested, image=:img WHERE id=:id";

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
                ':img' => $img,
                ':id' => $id,
            ]);
        } catch (mysqli_sql_exception $exception) {
            throw $exception;
        }
    }


    /* ----- FILTERS ----- */

    // filter's a validated sight by canton, category, age or budget and gets the sights. the parameter arrays will be sent using ajax.
    // parameter(s) : cantons_array, categories_array, ages_array, budget_array
    // returns array of data
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

            $sql .= 'AND validated = 1 GROUP BY a.id';

            $request = $db->prepare($sql);
            $request->execute();
            return $request->fetchAll();
            //return $sql;
        } catch (mysqli_sql_exception $exception) {
            return "error";
        }
    }

    /* -- BUDGET -- */

    // filter sight by budget
    // parameter(s) : budget
    // returns array of data
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

    /* -- CATEGORY -- */

    // get a category's id with it's name
    // parameter(s) : category_name
    // returns id
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

    // verifies if the sight has the given category(in parameter)
    // parameter(s) : id_category, id_sights
    // returns true or false
    public static function SightHasCategory($id_category, $id_sights)
    {
        try {
            $db = DBConnection::getConnection();
            $sql = "SELECT * FROM sights_contains_category WHERE id_category = :id_category AND id_sights = :id_sights";

            $request = $db->prepare($sql);
            $request->execute([':id_category' => $id_category, ':id_sights' => $id_sights]);
            if ($request->fetch() != 0) {
                return true;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $exception) {
            return false;
        }
    }

    // delete all sight's category
    // parameter(s) : id_sights
    // returns nothing
    public static function DeleteSightsCategories($id_sights)
    {
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

    // get all sight's categories
    // parameter(s) : id_sights
    // returns array of data
    public static function GetSightCategory($id_sights)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT a.name FROM category as a INNER JOIN sights_contains_category as b ON b.id_sights = :id_sights AND a.id = b.id_category";

        $request = $db->prepare($sql);
        $request->execute([':id_sights' => $id_sights]);
        return $request->fetchAll();
    }

    // get all categories
    // returns array of data
    public static function GetCategories()
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT * FROM category";

        $request = $db->prepare($sql);
        $request->execute();
        return $request->fetchAll();
    }

    // count all categories
    // returns count sum
    public static function CountCategoriesAmount()
    {
        $db = DBConnection::getConnection();
        $request = $db->query('SELECT count(*) from category');

        $request->execute();
        return $request->fetch();
    }

    // link a category to a sight
    // parameter(s) : category_name, id_sights
    // returns nothing
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

    /* -- AGE LIMIT -- */

    // verifies if the sight has the age limit(in parameter)
    // parameter(s) : id_age_limit, id_sights
    // returns true or false
    public static function SightHasAgeLimit($id_age_limit, $id_sights)
    {
        try {
            $db = DBConnection::getConnection();
            $sql = "SELECT * FROM sights_has_age_limit WHERE id_age_limit = :id_age_limit AND id_sights = :id_sights";

            $request = $db->prepare($sql);
            $request->execute([':id_age_limit' => $id_age_limit, ':id_sights' => $id_sights]);
            if ($request->fetch() != 0) {
                return true;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $exception) {
            return false;
        }
    }

    // delete all sight's age limit
    // parameter(s) : id_sights
    // returns nothing
    public static function DeleteSightsAgeLimits($id_sights)
    {
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

    // get all sight's age limits
    // parameter(s) : id_sights
    // returns array of data
    public static function GetSightAge($id_sights)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT a.name FROM age_limit as a INNER JOIN sights_has_age_limit as b ON b.id_sights = :id_sights AND a.id = b.id_age_limit";

        $request = $db->prepare($sql);
        $request->execute([':id_sights' => $id_sights]);
        return $request->fetchAll();
    }

    // get age's id with it's name
    // parameter(s) : age_name
    // returns id
    public static function GetAgeIdByName($age_name)
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT id FROM age_limit WHERE name = :age_name";

        $request = $db->prepare($sql);
        $request->execute([':age_name' => $age_name]);
        return $request->fetch();
    }

    // get all age limits
    // returns array of data
    public static function GetAgeLimits()
    {
        $db = DBConnection::getConnection();
        $sql = "SELECT * FROM age_limit";

        $request = $db->prepare($sql);
        $request->execute();
        return $request->fetchAll();
    }

    // count all age limits
    // returns count sum
    public static function CountAgeLimitsAmount()
    {
        $db = DBConnection::getConnection();
        $request = $db->query('SELECT count(*) from age_limit');

        $request->execute();
        return $request->fetch();
    }

    // link age limit to a sight
    // parameter(s) : id_age_limit, id_sights
    // returns nothing
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

    /* -- Search Bar -- */

    // checks if the input from the search bar corresponds to a sight name
    // parameter(s) : input
    // returns array of data
    public static function Search($input)
    {
        try {
            $db = DBConnection::getConnection();
            $sql = "SELECT * FROM sights WHERE validated = 1 AND name LIKE '%$input%'";

            $request = $db->prepare($sql);
            $request->execute();
            return $request->fetchAll();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
