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

function searchDataAdvanced( $product_color , $style , $subcategory , $material , $size_number , $sale_info_state , $order){
    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );
    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);

            $query = $pdo->prepare('SELECT p.product_id , s.size_number FROM pantofka.products as p
                    JOIN pantofka.sizes as s ON (s.product_id = p.product_id)
                    WHERE  (p.product_color = ? OR p.product_color IS NULL)
                    AND     (p.style = ? OR p.style IS NULL)
                    AND     (p.subcategory = ? OR p.subcategory IS NULL)
                    AND     (p.material = ? OR p.material IS NULL)
                    AND     (s.size_number = ? OR s.size_number IS NULL) 
                    AND     (p.sale_info_state = ? OR p.sale_info_state IS NULL) 
                    AND     (s.size_quantity > 0)
                    ORDER BY p.product_price ?;');
            $query->execute(array($product_color , $style , $subcategory , $material , $size_number , $sale_info_state , $order));
            $search_result = $query->fetch(PDO::FETCH_ASSOC);
            return $search_result;
}

