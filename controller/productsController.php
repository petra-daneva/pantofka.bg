<?php

require_once "./controller/../model/productDao.php";


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

$products = getProducts();


