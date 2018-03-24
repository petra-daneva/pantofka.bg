<?php



function productExists($product_name, $product_size, $product_color , $material , $product_style, $subcategory){

    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );
    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $query = $pdo->prepare('SELECT count(*) as product_exists FROM pantofka.products as p WHERE (p.product_name = ? AND p.product_size= ?  AND p.product_color= ?  AND p.material= ?  AND p.product_style= ?  AND p.subcategory= ?)');
    $query->execute(array($product_name, $product_size, $product_color , $material , $product_style, $subcategory));
    $query_result = $query->fetch(PDO::FETCH_ASSOC);
    return boolval($query_result["product_exists"]);
}

function saveProduct( $product_name, $product_size, $product_color , $material , $product_style, $subcategory, $product_price,$on_promotion, $price_on_promotion, $new_product, $product_img_name){
    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );
    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $query = $pdo->prepare('INSERT INTO pantofka.products ( product_name, product_size, product_color , material , product_style, subcategory, product_price,on_promotion, price_on_promotion, new_product, product_img_name) VALUES (?, ?, ? ,? , ?, ?, ?, ?, ?, ?, ?)');
    $query->execute(array( $product_name, $product_size, $product_color , $material , $product_style, $subcategory, $product_price,$on_promotion, $price_on_promotion, $new_product, $product_img_name));
}

function getProducts(){

    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );

    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);

    $row = $pdo->query('SELECT * FROM pantofka.products');
    $products =[];
    While ($query_result = $row->fetch(PDO::FETCH_ASSOC)){
        $products[] = $query_result;

    }
    return $products;
}