<?php

require_once "./controller/../model/productDao.php";


try{
    if (isset($_POST["add_product"])){
        $product_name = htmlentities($_POST["product_name"]);
        $product_size = htmlentities($_POST["product_size"]);
        $product_color = htmlentities($_POST["product_color"]);
        $material = htmlentities($_POST["material"]);
        $product_style = htmlentities($_POST["product_style"]);
        $subcategory= htmlentities($_POST["subcategory"]);
        $product_price = htmlentities($_POST["product_price"]);
        if (isset($_POST["on_promotion"])){
            $on_promotion = true;
            $price_on_promotion = htmlentities($_POST["price_on_promotion"]);
        }
        else{
            $on_promotion = false;
            $price_on_promotion = null;
        }
        if (isset($_POST["new_product"])){
            $new_product = true;
        }
        else{
            $new_product = false;
        }

        $tmp_name = $_FILES["picture_url"]["tmp_name"];
        $orig_name = $_FILES["picture_url"]["name"];

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
        if (!productExists( $product_name, $product_size, $product_color , $material , $product_style, $subcategory)){
            saveProduct( $product_name, $product_size, $product_color , $material , $product_style, $subcategory, $product_price,$on_promotion, $price_on_promotion, $new_product, $product_img_name);
            header("Location:index.php?page=successful_adding_product");

        }else{
            //If the product exist, try again

            header("Location:index.php?page=already_exists_product");

        }

    }

}catch(PDOException $e){
    echo "pdo exeption: " . $e->getMessage();

};

$products = getProducts();


