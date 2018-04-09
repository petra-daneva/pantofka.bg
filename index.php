<?php
    session_start();
    require_once 'controller/userController.php';
    require_once 'controller/productsController.php';


    $message = "";
    $error = "";
    $subcategory = "";
    $nested_error = "";

    $message = isset($COOKIE["message"])?htmlentities($_COOKIE["message"]):"";
    $error = isset($_COOKIE["error"])?htmlentities($_COOKIE["error"]):"";
    $nested_error = isset($_COOKIE["nested_error"])?htmlentities($_COOKIE["nested_error"]):"";

    $subcategory = isset($_GET["subcategory"])? htmlentities($_GET["subcategory"]):"men";
    setcookie("add_to_subcategory", $subcategory);

    $first_name = "";
    $last_name = "";
    $gender = "";
    $email = "";
    $email_exists = "";

    $first_name = isset($_COOKIE["first_name"])?htmlentities($_COOKIE["first_name"]):"";
    $last_name = isset($_COOKIE["last_name"])?htmlentities($_COOKIE["last_name"]):"";
    $gender = isset($_COOKIE["gender"])?htmlentities($_COOKIE["gender"]):"";
    $email = isset($_COOKIE["email"])?htmlentities($_COOKIE["email"]):"";
    $email_exists = isset($_COOKIE["email_exists"])?htmlentities($_COOKIE["email_exists"]):"";


    setcookie("error");
    setcookie("message");
    setcookie("nested_error");
    setcookie("email");
    setcookie("email_exists");
    setcookie("first_name");
    setcookie("last_name");
    setcookie("gender");


?>

<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Basic Page Needs
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta charset="utf-8">
    <title> Pantofka </title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Metas
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FONT
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

    <!-- CSS
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="stylesheet" href="./assets/css/default.css">
    <link rel="stylesheet" href="./assets/css/normalize.css">
    <link rel="stylesheet" href="./assets/css/skeleton.css">


    <!-- Favicon
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="icon" type="image/png" href="./assets/icons/favicon.png">

</head>
<body>

<!-- Primary Page Layout
–––––––––––––––––––––––––––––––––––––––––––––––––– -->
<div class="container">
    <div class="row">
        <div class="">
            <?php
            $not_triggered = true;
            $myErrorHandler = function ($errno, $errstr) use (&$not_triggered ){
                if ($not_triggered  == true){

                    echo "<b>Error:</b> [$errno] $errstr";
                    echo '<img src="assets/img/404.jpg">';

                    $not_triggered = false;
                }else{
                    $not_triggered  = false;
                }
            };

           // set_error_handler($myErrorHandler,E_ALL|E_STRICT);

            if (!isset($_SESSION["logged_user"])){
                    require_once "view/guest_navigation.php";
                }else{
                    require_once "view/user_navigation.php";
                }
                require_once "view/header.html";

            ?>

            <main class="bottom-30">

            <?php if (!empty($error) || !empty($message)): ?>

                <h6 class="error center"> <?= $error ?> </h6>
                <h6 class="message center"> <?= $message ?> </h6>

            <?php endif;

            if (isset($_GET["page"])){
                    $page = htmlentities($_GET['page']);

                    if (isset($_SESSION["logged_user"])) {
                        if ($page == "logout") {
                            unset($_SESSION["logged_user"]);
                            header("Location: index.php?page=main");
                            die();
                        }
                       elseif ($page == "add_product") {
                            if ($user_info["is_admin"] == 1) {
                                include_once "./view/add_product.php";
                            }else{
                                include_once "./view/error_page.php";
                            }
                        }else{
                            $page_link = './view/' . htmlentities($_GET['page']) . '.php';
                            include_once $page_link;
                        }


                    }else{

                        if ($page == "login"||  $page == "register" || $page = "product_info" ||$page == "logout" ||$page == "main"|| $page == "cart" ||$page == "favorites" || $page == "search"|| $page == "search_result" || $page == "my_search"|| $page == "my_search_result" ){

                            $page_link = './view/' . htmlentities($_GET['page']) . '.php';
                            include_once $page_link;
                        }else{
                           include_once "./view/error_page.php";
                        }
                    }
                }elseif (isset($_GET["products"])){

                    $type = htmlentities($_GET["products"]);
                    
                    if ($type == "men" ||$type == "new"   ||$type== "sale" || $type == "women" || $type == "girls" || $type == "boys" || $type="out_of_stock" || $type="result"){
                      //  $type_link = './view/' . htmlentities($_GET['products'] . ".php");
                        include_once "./view/display_subcategory_page.php";
                    }else{
                        include_once "view/error_page.php";
                    }

                }
                else{
                    include_once './view/main.php';
                }

            ?>

            </main>

            <?php

                require_once "./view/footer.html";

            ?>

        </div>
    </div>
</div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
