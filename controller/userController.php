<?php

require_once "./controller/../model/userDao.php";


// Button pressed. $_POST . Log a user by checking if such person exists in db and if so, add him into session like this $_SESSION["logged_user"] = $email;
try{
    if (isset($_POST["login_button"])){
        //Take data from form
        $email = htmlentities($_POST["email"]);
        $password = htmlentities($_POST["password"]);

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

    }

}catch(PDOException $e){
    header("Location: index.php?page=error_page");
    die();

};


// Button pressed. $_POST . Check if user exists and if not - add him inside db . Registration
try{
    if (isset($_POST["register_button"])){
        //Take data from form
        $first_name = htmlentities($_POST["first_name"]);
        $last_name = htmlentities($_POST["last_name"]);
        $gender = htmlentities($_POST["gender"]);
        $email = htmlentities($_POST["email"]);
        $password = htmlentities($_POST["password"]);
        $password_repeat = htmlentities($_POST["password_repeat"]);

        //validate data

        //Check if those exist with function from userDa0
        if (!userExists($email , sha1($password))){
            saveNewUser($first_name , $last_name , $gender , $email , sha1($password));
            header("Location:index.php?page=successful_registration");

        }else{
            //If such user exist -> he must log in

           header("Location:index.php?page=already_exists");

        }

    }

}catch(PDOException $e){
    echo "pdo exeption: " . $e->getMessage();

};


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


//Button pressed. $_POST . Edit profile - save changes
try{
    if (isset($_POST["save_profile_button"])){
        $logged_email = htmlentities($_SESSION["logged_user"]);
        $first_name = htmlentities($_POST["first_name"]);
        $last_name = htmlentities($_POST["last_name"]);
        $gender = htmlentities($_POST["gender"]);
        $email_new = htmlentities($_POST["email"]);
        $password_old = htmlentities($_POST["password_old"]);
        $password_new = htmlentities($_POST["password_new"]);
        updateUser($first_name , $last_name , $gender , $email_new , sha1($password_new) , $logged_email , sha1($password_old));
        $_SESSION["logged_user"] = $email_new;
    }

}catch (PDOException $e){
    header("Location: index.php?page=error_page");
    die();
}

