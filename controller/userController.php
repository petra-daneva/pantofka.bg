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
            header("Location: index.php?page=failed_login");
            die();
          }

        }else{
            setcookie("savedData" , $email);
            setcookie("error" , $error);
            header("Location: index.php?page=login");
            die();
        }
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
                header("Location:index.php?page=successful_registration");

            } else {
                //If such user exist -> he must log in
                setcookie("email_exists", "Email already exists!!");

            }

        }

        if (!empty($error) || isset($_COOKIE["email_exists"])) {
            setcookie("first_name", $first_name);
            setcookie("last_name", $last_name);
            setcookie("gender", $gender);
            setcookie("email", $email);
            setcookie("error", $error);
            header("Location: index.php?page=register");
            die();
        }

    }
}
catch(PDOException $e){
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

        }
            setcookie("first_name" , $first_name);
            setcookie("last_name" , $last_name);
            setcookie("gender" , $gender);
            setcookie("email" , $email_new);
            setcookie("error" , $error);
            setcookie("message", $message);
            header("Location: index.php?page=edit_profile");
            die();


    }

}catch (PDOException $e){
    header("Location: index.php?page=error_page");
    die();
}

