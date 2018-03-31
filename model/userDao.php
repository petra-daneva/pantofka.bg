<?php
//Ako neshto nqkyde,nqkoga v bazata ne ti trygva, nai-veroqtno e na save-mode https://stackoverflow.com/questions/11448068/mysql-error-code-1175-during-update-in-mysql-workbench

/**
 * Check if user exists by given email and password. Returns true if the user exists and false otherwise
 *
 * @param $email User data for login
 * @param $password User password for login
 * @return bool
 *
 */
function userExists($email , $password){
    //Establish connection
    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );

    //Error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    // Write query
    $query = $pdo->prepare('SELECT count(*) as user_exists FROM pantofka.users as u WHERE (u.user_email = ? AND u.user_password = ?)');
    // Put values
    $query->execute(array($email , $password));
    //Get the result
    $query_result = $query->fetch(PDO::FETCH_ASSOC);
    return boolval($query_result["user_exists"]);
}

/**
 * Inserts data. Add new user in db table. Set function -> Returns nothing
 *
 * @param $first_name
 * @param $last_name
 * @param $gender
 * @param $email
 * @param $password
 */
function saveNewUser($first_name , $last_name , $gender , $email , $password){
    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );
    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $query = $pdo->prepare("INSERT INTO pantofka.users ( user_fname, user_lname , user_gender , user_email, user_password) VALUES (? , ? ,? ,? , ?)");
    $query->execute(array($first_name , $last_name , $gender , $email , $password));
}

/**
 * Get data. Returns an array with (user_id , user_fname , user_lname , user_gender , is_admin (mixed:1 or null) ) user info from db by given email.
 *
 * @param $email : Identify the user from the session
 * @return mixed : Assoc array with keys user_id , user_fname , user_lname , user_gender , is_admin and corresponding values OR false if user does not exist
 */
function getUserData($email){
    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );
    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $query = $pdo->prepare("SELECT user_id , user_fname , user_lname , user_gender , is_admin FROM pantofka.users WHERE user_email = ?");
    $query->execute(array($email));
    $query_result = $query->fetch(PDO::FETCH_ASSOC);
    return $query_result;
}

/**
 * Set an update to already existing user in the db. Returns nothing
 *
 * @param $first_name
 * @param $last_name
 * @param $gender
 * @param $email_new
 * @param $password_new
 * @param $logged_email
 * @param $password_old
 */
function updateUser($first_name , $last_name , $gender , $email_new , $password_new , $logged_email , $password_old){
    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );
    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $query = $pdo->prepare("UPDATE pantofka.users SET user_fname = ? ,user_lname = ? ,user_gender = ? ,user_email = ? ,user_password = ? WHERE (user_email = ? && user_password = ? )");
    $query->execute(array($first_name , $last_name , $gender , $email_new , $password_new , $logged_email , $password_old));

}

/**
 * Return array containing o.date , p.product_name ,p.product_color,p.product_price,p.style , p.subcategory , p.material , s.size_number,p.product_img_name. by given user id. Every order is accessed through its date which is a key.
 *
 *
 * @param $user_id
 * @return array
 */
function getOrdersHistory($user_id){
    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );
    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $query = $pdo->prepare("SELECT  o.date , p.product_name ,p.product_color,p.product_price,
            p.style , p.subcategory , p.material , s.size_number,p.product_img_name, sale_info_state, sale_price
            FROM pantofka.orders as o 
            JOIN pantofka.sizes as s USING (size_id)
            JOIN pantofka.products as p ON (o.product_id = p.product_id) 
            WHERE user_id = ? ORDER BY o.date DESC");
    $query->execute(array($user_id));
    $user_orders = array();
    while($order = $query->fetch(PDO::FETCH_ASSOC)){
        $user_orders[] = $order;
    }
    return $user_orders;
}

function filterOrdersHistory($item_ids){
    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );
    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $place_holders = implode(',', array_fill(0, count($item_ids), '?'));
    $query = $pdo->prepare("SELECT o.date , p.product_name , p.product_color , p.product_price , p.style ,
                                             p.subcategory , p.material , s.size_number , p.product_img_name ,
                                             p.sale_info_state , p.sale_price 
                                            FROM pantofka.orders as o 
                                            INNER JOIN pantofka.products as p USING (product_id)
                                            INNER JOIN pantofka.sizes as s USING (product_id) 
                                            WHERE p.product_id IN (". $place_holders . ")" );
    $query->execute($item_ids);
    $orders = array();
    while($order = $query->fetch(PDO::FETCH_ASSOC)){
        $orders[] = $order;
    }
    return $orders;
}

/**
 * getAll...() functions returns the types of specific characteristic from db. It was used for displaying all options in adv. search
 * @return array with characteristic names
 */
function getAllColors(){
    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );
    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $query = $pdo->prepare("SELECT DISTINCT product_color FROM pantofka.products");
    $query->execute();
    while($color = $query->fetch(PDO::FETCH_ASSOC)){
        $colors[] = $color;
    }
    return $colors;
}

function getAllMaterials(){
    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );
    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $query = $pdo->prepare("SELECT DISTINCT material FROM pantofka.products");
    $query->execute();
    while($material = $query->fetch(PDO::FETCH_ASSOC)){
        $materials[] = $material;
    }
    return $materials;
}

function getAllStyles(){
    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );
    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $query = $pdo->prepare("SELECT DISTINCT style FROM pantofka.products");
    $query->execute();
    while($style = $query->fetch(PDO::FETCH_ASSOC)){
        $styles[] = $style;
    }
    return $styles;
}

function getAllCollections(){
    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );
    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $query = $pdo->prepare("SELECT DISTINCT sale_info_state FROM pantofka.products");
    $query->execute();
    while($collection = $query->fetch(PDO::FETCH_ASSOC)){
        $collections[] = $collection;
    }
    return $collections;
}

function getAllSubcategories(){
    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );
    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $query = $pdo->prepare("SELECT DISTINCT subcategory FROM pantofka.products");
    $query->execute();
    while($subcategory = $query->fetch(PDO::FETCH_ASSOC)){
        $subcategories[] = $subcategory;
    }
    return $subcategories;
}

/**
 * This function returns all possible combination of unique items from db in array. It was used in advanced search.
 * @param $colors
 * @param $materials
 * @param $subcategories
 * @param $styles
 * @param $collections
 * @return array with ids
 */
function getSearchResults($colors , $materials , $subcategories , $styles , $collections)
{
    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS, PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    /* Create a string for the parameter placeholders filled to the number of params */
    $place_holder_colors = implode(',', array_fill(0, count($colors), '?'));
    $place_holder_materials = implode(',', array_fill(0, count($materials), '?'));
    $place_holder_subcategories = implode(',', array_fill(0, count($subcategories), '?'));
    $place_holder_styles = implode(',', array_fill(0, count($styles), '?'));
    $place_holder_collections = implode(',', array_fill(0, count($collections), '?'));
    $query = $pdo->prepare('SELECT DISTINCT product_id , product_img_name
                                    FROM pantofka.products 
                                    WHERE product_color IN ('.$place_holder_colors.') 
                                    AND material IN ('.$place_holder_materials.')
                                    AND subcategory IN ('.$place_holder_subcategories.') 
                                    AND sale_info_state IN ('.$place_holder_collections.')
                                    AND style IN ('.$place_holder_styles.') 
                                  ');

    $merged = array_merge($colors , $materials , $subcategories ,$collections, $styles); // Assoc
    $merged = array_values($merged); // Numeric
    $query->execute($merged);
    $search_result = array();
    while ($some_product = $query->fetch(PDO::FETCH_ASSOC)){
        $search_result[] = $some_product ;
    };
    return $search_result;
}

//example use:  $colors_result = getSearchResultsFor($colors , "product_color"); This is 1D version of getSearchResult
function getSearchResultsFor($characteristic_value , $characteristic_name)
{
    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS, PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    /* Execute a prepared statement using an array of values for an IN clause */
    $params = $characteristic_value;

    /* Create a string for the parameter placeholders filled to the number of params */
    $place_holders = implode(',', array_fill(0, count($params), '?'));

    /*
        This prepares the statement with enough unnamed placeholders for every value
        in our $params array. The values of the $params array are then bound to the
        placeholders in the prepared statement when the statement is executed.
        This is not the same thing as using PDOStatement::bindParam() since this
        requires a reference to the variable. PDOStatement::execute() only binds
        by value instead.
    */
    $query = $pdo->prepare('SELECT product_id FROM pantofka.products where '.$characteristic_name .' IN ('.$place_holders.')');
    $query->execute($params);
    $search_result = [];
    while ($some_product  = $query->fetch(PDO::FETCH_ASSOC)){
        $search_result[] = $some_product ;
    }

    return $search_result;

}

/**
 * This function, by given array of keywords and specific name of a table returns the ids of all products,
 * containing parts of different keywords.  The parameter table_name is passed by userController.
 * I am not sure if it was okay to put it like this in query , but as far as my logic goes it cant bring a problem like this.
 * I done it like this so i can re-use the function for every table, instead of copy-pasting it
 *
 * @param $input
 * @param $table_name
 * @return array with id's
 */
function getResultsByKeywords($input , $table_name){
    try{
        //Validation of table name input, coming from controller.
        if ($table_name != "product_name" &&
            $table_name != "product_color" &&
            $table_name != "sale_info_state" &&
            $table_name != "style" &&
            $table_name != "subcategory" &&
            $table_name != "material" ){

            throw new Exception("Not cool. Check data in controller for searching by string  input is - " . var_dump($table_name));
        }
    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS, PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();
    $search_result = array();
    foreach ($input as $key_word) {
        //Since i want to use parametrized values and at the same time to check if string is part of other string
        //I add %s outside the query and pass the keyword with them.That way i can check for every word.
        $key_word = "%".$key_word."%";
        $query = $pdo->prepare("SELECT product_id FROM pantofka.products as p WHERE p.$table_name LIKE ? ");
        $query->execute(array($key_word));
        while ($some_product  = $query->fetch(PDO::FETCH_ASSOC)){
            $id = $some_product["product_id"];
            //I am puting the id as a key so the next time i use the function, if i do merging for example,
            // it will be easier for me to filter unique elements
            $search_result[$id] = $some_product ;
        }
    }
    $pdo->commit();
    return $search_result;
    }catch (PDOException $e){
      echo $e->getMessage();
      $e->rollback();
        throw $e;
    }catch (Exception $ex){
       echo $ex->getMessage();
    }

}

/**
 * Same as getResultsByKeywords() , with the only difference of searching in orders table , instead of products's one.
 * @param $input
 * @param $table_name
 * @return array
 */
function getHistoryByKeywords($input , $table_name){

    try{
        if ($table_name != "product_name" &&
            $table_name != "product_color" &&
            $table_name != "sale_info_state" &&
            $table_name != "style" &&
            $table_name != "subcategory" &&
            $table_name != "material" ){

            throw new Exception("Not cool. Check data in controller for searching by string  input is - " . var_dump($table_name));
        }
        require_once "././model/dbmanager.php";
        $pdo = new PDO(PDO_CONNECTION_DNS, PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        $search_result = array();
        foreach ($input as $key_word) {
            $key_word = "%".$key_word."%";
            //name coll color size material , "product_color" , "sale_info_state" , "style" , "subcategory" , "material"
            $query = $pdo->prepare("SELECT p.product_id
                                             FROM pantofka.orders as o 
                                             JOIN pantofka.products as p USING (product_id) 
                                             WHERE p.$table_name LIKE ? ");
            $query->execute(array($key_word));
            while ($some_product  = $query->fetch(PDO::FETCH_ASSOC)){
                $id = $some_product["product_id"];
                $search_result[$id] = $some_product ;
            }
        }
        $pdo->commit();
        return $search_result;
    }catch (PDOException $e){
       // $e->rollback();
        throw $e;
        echo $e->getMessage();

    }catch (Exception $ex){
        echo $ex->getMessage();
    }

}