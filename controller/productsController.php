<?php
require_once "./controller/../model/productDao.php";


    $products = getProducts();
    $error = "";


    try{
        if (isset($_POST["add_product"])){
            $product_name = htmlentities($_POST["product_name"]);
            $product_color = htmlentities($_POST["product_color"]);
            $material = htmlentities($_POST["material"]);
            $style = htmlentities($_POST["style"]);
            $subcategory= htmlentities($_POST["subcategory"]);
            $product_price = htmlentities($_POST["product_price"]);
            $sale_info_state = htmlentities($_POST["sale_info_state"]);
            $size_number=htmlentities($_POST["size_number"]);
            $size_quantity=htmlentities($_POST["size_quantity"]);

            $tmp_name = $_FILES["product_img_name"]["tmp_name"];
            $orig_name = $_FILES["product_img_name"]["name"];

            if(is_uploaded_file($tmp_name)){
                $product_img_name = "$product_name-" . date("Ymdhisa") . ".png";
                $picture_url = "assets/products_imgs/$product_img_name";
                if(move_uploaded_file($tmp_name, $picture_url)){

                }
                else{
                    // error The picture not moved
                }
            }
            else{
                // error The picture is not uploade
                $error .= "Picture not uploaded! ";

            }
            if (empty($error)){
                // Checking if the product already exist
                if (!productExists( $product_name,$size_number, $product_color , $material , $style, $subcategory)){
                    saveProduct( $product_name, $size_number, $size_quantity, $product_color , $material , $style, $subcategory, $product_price,$sale_info_state, $product_img_name);
                    setcookie("product_added_successfully" , "Product added successfully");
                    header("Location:index.php?page=add_product");
                    die();
                }else{
                    $error .= "Product already exists! ";

            }

            }

            setcookie("product_name" ,$product_name );
            setcookie("product_color" ,$product_color );
            setcookie("material" ,$material );
            setcookie("style" ,$style );
            setcookie("subcategory" ,$subcategory );
            setcookie("product_price" ,$product_price );
            setcookie("sale_info_state" ,$sale_info_state );
            setcookie("size_number" ,$size_number );
            setcookie("size_quantity" ,$size_quantity );
            header("Location:index.php?page=add_product");
            die();
        }

        }catch(PDOException $e){
            echo "pdo exeption: " . $e->getMessage();

        };

    if (isset($_POST["edit_product"])) {
        $_SESSION["edit_product"] = [];
        foreach ($products as $product){
            if ($product["product_id"] == $_POST["product_id"]){
                $_SESSION["edit_product"] = $product;
                break;
            }
        }
        header("location:index.php?page=edit_product");
    }

    try {
        if(isset($_POST["change_product"])) {
            $product_id = $_SESSION["edit_product"]["product_id"];
            $product_name = htmlentities($_POST["product_name"]);
            $product_color = htmlentities($_POST["product_color"]);
            $material = htmlentities($_POST["material"]);
            $style = htmlentities($_POST["style"]);
            $subcategory = htmlentities($_POST["subcategory"]);
            $product_price = htmlentities($_POST["product_price"]);
            $sale_info_state = htmlentities($_POST["sale_info_state"]);
            $sale_price = htmlentities($_POST["sale_price"]);
            $product_img_name = htmlentities($_POST["product_img_name"]);
            $sizes = [];
            $product = [];
            $new_size = false;
            if($_POST["new_size"] > 20 && $_POST["new_size"] < 50 && $_POST["new_quantity"] > 0 ){
                $new_size = [];
                $new_size["size_number"]= htmlentities($_POST["new_size"]);
                $new_size["size_quantity"] = htmlentities($_POST["new_quantity"]);
            }

         $sizes = $_SESSION["edit_product"]["sizes"];
            foreach ($sizes as &$size) {
                $size_number= $size["size_number"];
               $size["size_quantity"] = $_POST["$size_number"];

                if ($new_size != false) {
                    if ($new_size["size_number"] == $size_number) {
                      $new_size = false;

                    }
                }
            }


            if (isset($_FILES["product_img_name"])) {
                $tmp_name = $_FILES["product_img_name"]["tmp_name"];
                $orig_name = $_FILES["product_img_name"]["name"];

                if (is_uploaded_file($tmp_name)) {
                    $product_img_name = "$product_name-" . date("Ymdhisa") . ".png";
                    $picture_url = "assets/products_imgs/$product_img_name";
                    if (move_uploaded_file($tmp_name, $picture_url)) {

                    } else {
                        // error The picture not moved
                    }
                } else {
                    // error The picture is not uploaded
                }
            }
            unset($_SESSION["edit_product"]);
            changeProduct($product_id, $product_name, $product_color, $material, $style , $subcategory , $product_price, $sale_info_state, $product_img_name, $sale_price,$sizes, $new_size );
            unset($_SESSION["edit_product"]);
        }

    }catch(PDOException $e){
    echo "pdo exeption: " . $e->getMessage();


};

    if (isset($_SESSION["cart"])){
        $cart_items = &$_SESSION["cart"];

    }else{
        $_SESSION["cart_total_price"] = 0;
        $cart_items = array();
    }

    if (isset($_GET["remove_cart"])){
        $item_no = htmlentities($_GET["remove_cart"]);
        unset($cart_items[$item_no]);
        unset($_SESSION["cart"][$item_no]);
    }

    if (isset($_SESSION["favorites"])){
        $favorites_items = &$_SESSION["favorites"];
    }else{
        $favorites_items = array();
    }

    if (isset($_GET["move_to_cart"])){
        $product_id = htmlentities($_GET["product_id"]);
        $product_size = htmlentities($_GET["size"]);
        $product_to_cart = [];
        $product_to_cart = getProductData($product_id);
        $product_to_cart["size"]=$product_size;
        $_SESSION["cart"][] = $product_to_cart;
        $item_no = htmlentities($_GET["move_to_cart"]);


    }

    if (isset($_GET["remove_favorites"])){
        $item_no = htmlentities($_GET["remove_favorites"]);
        unset($favorites_items[$item_no]);
        unset($_SESSION["favorites"][$item_no]);

    }

    try{
            if (isset($_POST["add_to_cart"])){
                //Terry
                $product_id = htmlentities($_POST["product_id"]);
                $product_size = htmlentities($_POST["size"]);
                $product_to_cart = [];
                $product_to_cart = getProductData($product_id);
                $product_to_cart["size"]=$product_size;
                $_SESSION["cart"][] = $product_to_cart;
            }

    }catch (PDOException $e){
                echo "pdo exception: " . $e->getMessage();
            }

    try{
        $product_size = "";
        if (isset($_POST["add_to_favourites"])){
            $product_id = htmlentities($_POST["product_id"]);
            $id_exists = false;
            foreach ($favorites_items as $item) {
                foreach ($item as $key=>$value) {
                    if ($key == "product_id" && $value == $product_id ){
                        $id_exists = true;
                        break;
                     }
                }
            }
            if ($id_exists == false) {
                // Terry
                $product_size = htmlentities( $_POST["size"]);
                $product_to_fav = [];
                $product_to_fav = getProductData($product_id);
                $product_to_fav["size"]=$product_size;
                $_SESSION["favorites"][] = $product_to_fav;
            }
        }

    }catch (PDOException $e){
        echo "pdo exception: " . $e->getMessage();
    }

    try{
        if (isset($_POST["buy_cart"])){
            $items_to_buy = array();
            foreach ($_SESSION["cart"] as $item) {
                $items_to_buy[] = ["product_id" => $item["product_id"] , "product_size" => $item["size"]];
            }
            if (isset($_SESSION["logged_user"])){
                $user_id = $user_info["user_id"];
                setOrder($items_to_buy , $user_id );
                $_SESSION["cart"] = array();
                $_SESSION["cart_total_price"] = 0;
                header("Location: index.php?page=history");
                die();
            }

        }

    }catch(PDOException $e){
        echo "pdo exception: " . $e->getMessage();

    }


    try{
        if (isset($_POST["delete_product"])){
            $product_id = htmlentities($_POST["product_id"]);
            removeProduct($product_id);
            $current_page = $_SERVER['REQUEST_URI'];
            setcookie("message" , "Product was removed successfully! ");
            header("Location:" . $current_page);
            die();
        }

    }catch(PDOException $e){
    echo "pdo exception: " . $e->getMessage();

}




