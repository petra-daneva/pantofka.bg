<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pantofka</title>
    <link rel="stylesheet" href="assets/default.css" type="text/css">
</head>
    <body>
        <div id="container" class="bottom-30">
            <?php

            require_once 'controller/userController.php';
            require_once 'controller/productsController.php';

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

            set_error_handler($myErrorHandler,E_ALL|E_STRICT);
            if (!isset($_SESSION["logged_user"])){
                    require_once "view/guest_navigation.html";
                }else{
                    require_once "view/user_navigation.php";
                }
                require_once "view/header.html";

            ?>

            <main class="bottom-30">

            <?php

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
                        if ($page == "login"||  $page == "register" ||$page == "logout" ||$page == "main"|| $page == "cart" ||$page == "favorites" || $page == "already_exists" || $page == "failed_login" || $page == "successful_registration"){
                            $page_link = './view/' . htmlentities($_GET['page']) . '.php';
                            include_once $page_link;
                        }else{
                           include_once "./view/error_page.php";
                        }
                    }
                }elseif (isset($_GET["products"])){

                    $type = htmlentities($_GET["products"]);
                    
                    if ($type == "men" || $type == "women" || $type == "girls" || $type == "boys"){
                        $type_link = './view/' . htmlentities($_GET['products'] . ".php");
                        include_once $type_link;
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
    </body>
</html>