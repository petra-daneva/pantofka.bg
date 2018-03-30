<?php

require_once "./controller/../model/userDao.php";

$error = "";
$message = "";

// Session.$_SESSION['logged_user']. When a user is logged in - get the data about him in $user_info array
try{
    if (isset($_SESSION["logged_user"])){
        $logged_email = htmlentities($_SESSION["logged_user"]);
        $user_info = getUserData($logged_email);
    }
}catch (PDOException $e){
    header("Location: index.php?page=error_page");
    die();
};


// Button pressed. $_POST . Log a user by checking if such person exists in db and if so, add him into session like this $_SESSION["logged_user"] = $email;
try{
    if (isset($_POST["login_button"])){
        //Take data from form
        $email = htmlentities($_POST["email"]);
        $password = htmlentities($_POST["password"]);

       if (empty($email) || empty($password)){
           $error .= "You must fill all the blankets! ";
       }
        if (strlen($email) > 50 || strlen($password) > 50){
           $error .= "Input value is too long! ";
        }
        if (strpos($email , "@") === false){
            $error .= "This is not a valid email";
        }

        if (empty($error)){
        //Check if those exist with function from userDa0
        if (userExists($email , sha1($password))){
            //If such user exist -> log him into session
            $_SESSION["logged_user"] = $email;
            //Redirect him to profile
            header("Location: index.php?page=edit_profile");
            die();
        }else{
            $error = "Wrong username or password!! ";
          }

        }
            setcookie("email" , $email);
            setcookie("error" , $error);
            header("Location: index.php?page=login");
            die();
        }

    }catch(PDOException $e){
        header("Location: index.php?page=error_page");
        die();

    };


// Button pressed. $_POST . Check if user exists and if not - add him inside db . Registration
try{
    if (isset($_POST["register_button"])) {
        //Take data from form
        $first_name = htmlentities($_POST["first_name"]);
        $last_name = htmlentities($_POST["last_name"]);
        $gender = htmlentities($_POST["gender"]);
        $email = htmlentities($_POST["email"]);
        $password = htmlentities($_POST["password"]);
        $password_repeat = htmlentities($_POST["password_repeat"]);

        //validate data
        if (empty($first_name) || empty($last_name) || empty($gender) || empty($email) || empty($password) || empty($password_repeat)) {
            $error .= "You must fill all the blankets! ";
        }
        if (strlen($first_name) > 45 || strlen($last_name) > 45 || strlen($email) > 45 || strlen($password) > 45 || strlen($password_repeat) > 45) {
            $error .= "Input value is too long! ";
        }
        if (strpos($email, "@") === false) {
            $error .= "This is not a valid email! ";
        }
        if ($password !== $password_repeat) {
            $error .= "Passwords mismatched! ";
        }
        if (strlen($password) < 5 || strlen($password_repeat) < 5) {
            $error .= "Password must be at least 5 symbols long! ";
        }

        if (empty($error)) {

            //Check if those exist with function from userDa0
            if (!userExists($email, sha1($password))) {
                saveNewUser($first_name, $last_name, $gender, $email, sha1($password));
                setcookie("email", $email);
                setcookie("message", "Registration was successful! You can now log in. ");
                header("Location:index.php?page=login");
                die();

            } else {
                //If such user exist -> he must log in
                setcookie("email_exists", "Email already exists!!");

            }

        }

        setcookie("first_name", $first_name);
        setcookie("last_name", $last_name);
        setcookie("gender", $gender);
        setcookie("email", $email);
        setcookie("error", $error);
        header("Location: index.php?page=register");
        die();


    }
} catch(PDOException $e){
            echo "pdo exception: " . $e->getMessage();

        };


//Button pressed. $_POST . Edit profile - save changes
try{
    if (isset($_POST["save_profile_button"])){

        $logged_email = htmlentities($_SESSION["logged_user"]);
        $first_name = htmlentities($_POST["first_name"]);
        $last_name = htmlentities($_POST["last_name"]);
        $gender = htmlentities($_POST["gender"]);
        $email_new = htmlentities($_POST["email"]);
        $password_old = htmlentities($_POST["password_old"]);
        $password_repeat = htmlentities($_POST["password_repeat"]);

        $password_new = htmlentities($_POST["password_new"]);
        //validate data
        if (empty($first_name) || empty($last_name) || empty($gender) || empty($email_new) || empty($password_old) || empty($password_repeat)){
            $error .= "You must fill all the blankets! ";
        }
        if (strlen($first_name) > 45 || strlen($last_name) > 45 || strlen($email_new) > 45 || strlen($password_old) > 45 ||strlen($password_repeat) > 45|| strlen($password_new) > 45){
            $error .= "Input value is too long! ";
        }
        if (strpos($email_new , "@") === false){
            $error .= "This is not a valid email! ";
        }
        if ($password_old !== $password_repeat){
            $error .= "Passwords mismatched! ";
        }
        if (strlen($password_old) < 3 || strlen($password_repeat) < 3){
            $error .= "Password must be at least 5 symbols long! ";
        }
        if (!empty($password_new) && strlen($password_new) < 5){
            $error .= "New password must be at least 5 symbols long! ";
        }

        if (empty($error)){
            $add_password = (empty($password_new))?($password_old):($password_new);
            updateUser($first_name , $last_name , $gender , $email_new , sha1($add_password) , $logged_email , sha1($password_old));
            $_SESSION["logged_user"] = $email_new;
            $message = "Successful edit";
            setcookie("message", $message);
            header("Location: index.php?page=edit_profile");
            die();

        }
            setcookie("first_name" , $first_name);
            setcookie("last_name" , $last_name);
            setcookie("gender" , $gender);
            setcookie("email" , $email_new);
            setcookie("error" , $error);
            header("Location: index.php?page=edit_profile");
            die();


    }

}catch (PDOException $e){
    echo "pdo exception: " . $e->getMessage();

}

// Take history of orders from db
try{
    if (isset($_SESSION["logged_user"])){
        $user_id = $user_info["user_id"];
        $orders_history = getOrdersHistory($user_id);
    }
}catch (PDOException $e){
    echo "pdo exception: " . $e->getMessage();

}

// Get all data needed for search
if (isset($_GET["page"] )){
    if ($_GET["page"] == "search_result" || $_GET["page"] == "search" ){

    try{
        $all_colors  = getAllColors();
    }catch (PDOException $e){
        $all_colors = $e->getMessage();
    }

    try{
        $all_materials  = getAllMaterials();
    }catch (PDOException $e){
        $all_materials = $e->getMessage();
    }

    try{
        $all_collections  = getAllCollections();
    }catch (PDOException $e){
        $all_collections = $e->getMessage();
    }

    try{
        $all_styles  = getAllStyles();
    }catch (PDOException $e){
        $all_styles = $e->getMessage();
    }

    try{
        $all_subcategories  = getAllSubcategories();
    }catch (PDOException $e){
        $all_subcategories = $e->getMessage();
    }
    }
}


try{
    if (isset($_POST["advanced_search"])){
        $product_color = array();
        if (isset($_POST["colors"])){
            $product_color = ($_POST["colors"]);
        }else{
            foreach ($all_colors as $single_color) {
                foreach ($single_color as $item) {
                    $val =  $single_color["product_color"];

                    $product_color[$val] = $single_color["product_color"];
                }
            }

        }

        $material = array();
        if (isset($_POST["materials"])){
            $material = ($_POST["materials"]);
        }else{

            foreach ($all_materials as $single_material) {
                foreach ($single_material as $item) {
                    $val = $single_material["material"];
                    $material[$val] = $val;
                }
            }


        }

        $subcategory = array();
        if (isset($_POST["subcategory"])){
            $subcategory = ($_POST["subcategory"]);
        }else{
            foreach ($all_subcategories as $single_subcategory) {
                foreach ($single_subcategory as $item) {
                    $val = $single_subcategory["subcategory"];
                    $subcategory[$val] = $val;
                }
            }
        }

        $styles = array();
        if (isset($_POST["style"])){
            $styles = ($_POST["style"]);
        }else{
            foreach ($all_styles as $single_style) {
                foreach ($single_style as $item) {
                    $val = $single_style["style"];
                    $styles[$val] = $val;
                }
            }

        }


        $collections = array();
        if (isset($_POST["sale_info_state"])){
            $collections = ($_POST["sale_info_state"]);
        }else{

            foreach ($all_collections as $single_collection) {
                foreach ($single_collection as $item) {
                    $val = $single_collection["sale_info_state"];
                    $collections[$val] = $val;
                }
            }
        }

        $advanced_search_result = getSearchResults($product_color, $material , $subcategory , $styles , $collections);
    }
}catch (PDOException $e){
    $e->getMessage();
}



try{
if (isset($_POST["search_history_button"])){
    $input = htmlentities($_POST["search_history_input"]);
    if (strlen($input) > 30){
        setcookie("error" , "Input too long!");
        header("Location:index.php?page=history");
        die();
    }

    $input = explode(" " , $input);
    $history_by_name_str = getHistoryByKeywords($input , "product_name");
    $history_by_collection_str = getHistoryByKeywords($input , "sale_info_state");
    $history_by_material_str = getHistoryByKeywords($input , "material");




}
}catch (PDOException $e){

}


try{
    if (isset($_POST["search_bar_button"])){
        $input = htmlentities($_POST["search_bar_input"]);
        if (strlen($input) > 30){
            setcookie("error" , "Input too long!");
            header("Location:index.php?page=search");
            die();
        }

        $input = explode(" " , $input);
        $search_by_name_str = getResultsByKeywords($input , "product_name");
        $search_by_collection_str = getResultsByKeywords($input , "sale_info_state");
        $search_by_material_str = getResultsByKeywords($input , "material");




    }
}catch (PDOException $e){

}