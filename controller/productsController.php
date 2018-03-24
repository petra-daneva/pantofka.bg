<?php


require_once "./controller/../model/productDao.php";

$products = getProducts();

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
            // error The picture is not uploaded
        }
        // Checking if the product already exist
        if (!productExists( $product_name,$size_number, $product_color , $material , $style, $subcategory)){
            saveProduct( $product_name, $size_number, $size_quantity, $product_color , $material , $style, $subcategory, $product_price,$sale_info_state, $product_img_name);
            header("Location:index.php?page=successful_adding_product");

        }else{
            //If the product exist, try again

            header("Location:index.php?page=already_exists_product");

        }

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
         $product_id = htmlentities($_POST["product_id"]);
         $product_name = htmlentities($_POST["product_name"]);
         $product_color = htmlentities($_POST["product_color"]);
         $material = htmlentities($_POST["material"]);
         $style = htmlentities($_POST["style"]);
         $subcategory = htmlentities($_POST["subcategory"]);
         $product_price = htmlentities($_POST["product_price"]);
         $sale_info_state = htmlentities($_POST["sale_info_state"]);
         $sale_price = htmlentities($_POST["sale_price"]);

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
         } else {
             $product_img_name = htmlentities($_POST["product_img_name"]);
         }
         changeProduct($product_id, $product_name, $product_color, $material, $style , $subcategory , $product_price, $sale_info_state, $product_img_name, $sale_price );

}


}catch(PDOException $e){
    echo "pdo exeption: " . $e->getMessage();


};
// Add items into the cart. Pepsy was here, blame her if something went wrong :D  // NEVER! :D \\

// Well, guess everything was okay then :D

    if (isset($_SESSION["cart"])){
        $cart_items = &$_SESSION["cart"];

    }else{
        $_SESSION["cart_total_price"] = 0;
        $cart_items = array();
    }

    if (isset($_GET["remove_cart"])){
        $item_no = htmlentities($_GET["remove_cart"]);
        $_SESSION["cart_total_price"] -= $cart_items[$item_no]["product_price"];
        unset($cart_items[$item_no]);
        unset($_SESSION["cart"][$item_no]);
    }

    if (isset($_SESSION["favorites"])){
        $favorites_items = &$_SESSION["favorites"];
    }else{
        $favorites_items = array();
    }

    if (isset($_GET["remove_favorites"])){
        $item_no = htmlentities($_GET["remove_favorites"]);
        unset($favorites_items[$item_no]);
        unset($_SESSION["favorites"][$item_no]);
    }

    try{
            $product_id = "";
            if (isset($_POST["add_to_cart"]) || isset($_GET["add_to_cart"])){
                $product_id = isset($_GET["add_to_cart"]) ? htmlentities($_GET["id"]) : htmlentities($_POST["product_id"]);
                $data = getProductData($product_id);
                $_SESSION["cart_total_price"] += $data["product_price"];
                $_SESSION["cart"][] = $data;

            }

            }catch (PDOException $e){
                echo "pdo exception: " . $e->getMessage();
            }

    try{
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
                $_SESSION["favorites"][] = getProductData($product_id);
            }
        }
    }catch (PDOException $e){
        echo "pdo exception: " . $e->getMessage();
    }

    try{
        if (isset($_POST["buy_cart"])){
            $items_to_buy = array();
            foreach ($_SESSION["cart"] as $item) {
                $items_to_buy[] = $item["product_id"];
            }
            if (isset($_SESSION["logged_user"])){
                setOrder($items_to_buy , $user_info["user_id"]);
                $_SESSION["cart"] = array();
                $_SESSION["cart_total_price"] = 0;
                header("Location: index.php?page=successful_order");
                die();
            }else{
                setcookie("message" , "Log in to make an order");
                header("Location: index.php?page=login");
                die();
            }
        }}catch(PDOException $e){
        echo "pdo exception: " . $e->getMessage();

    }

