<?php



function productExists($product_name, $product_color , $material , $style, $subcategory){

    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );
    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $query = $pdo->prepare('SELECT count(*) as product_exists FROM pantofka.products as p WHERE (p.product_name = ?  AND p.product_color= ?  AND p.material= ?  AND p.style= ?  AND p.subcategory= ?)');
    $query->execute(array($product_name,  $product_color , $material , $style, $subcategory));
    $query_result = $query->fetch(PDO::FETCH_ASSOC);
    return boolval($query_result["product_exists"]);
}

function saveProduct( $product_name, $size_number, $size_quantity, $product_color , $material , $style, $subcategory, $product_price,$sale_info_state, $product_img_name){
    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );
    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $query = $pdo->prepare('INSERT INTO pantofka.products ( product_name, product_color , material , style, subcategory, product_price, sale_info_state, product_img_name) VALUES (?, ?, ? ,? , ?, ?, ?, ?)');
    $query->execute(array( $product_name, $product_color , $material , $style, $subcategory, $product_price, $sale_info_state, $product_img_name));

    $query = $pdo->prepare('SELECT p.product_id FROM pantofka.products as p WHERE (p.product_name = ?  AND p.product_color= ?  AND p.material= ?  AND p.style= ?  AND p.subcategory= ? )');
    $query->execute(array($product_name, $product_color, $material, $style, $subcategory));
    $product_id = $query->fetch(PDO::FETCH_ASSOC);

    $query = $pdo->prepare('INSERT INTO sizes (size_number, size_quantity, product_id) Values (?, ?, ?)');
    $query->execute(array($size_number, $size_quantity, $product_id["product_id"]));

}


function saveSize($product_name, $size_number, $size_quantity, $product_color , $material , $style, $subcategory, $product_price)
{
    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS, PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $pdo->prepare('SELECT p.product_id FROM pantofka.products as p WHERE (p.product_name = ?  AND p.product_color= ?  AND p.material= ?  AND p.style= ?  AND p.subcategory= ?)');
    $query->execute(array($product_name, $product_color, $material, $style, $subcategory));
    $product_id = $query->fetch(PDO::FETCH_ASSOC);

    $query = $pdo->prepare('INSERT INTO sizes (size_number, size_quantity, product_id) Values (?, ?, ?)');
    $query->execute(array($size_number, $size_quantity, $product_id));

}

function getProducts(){

    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS, PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $row = $pdo->query('SELECT * FROM pantofka.products');
    $products = [];
    While ($query_result = $row->fetch(PDO::FETCH_ASSOC)) {
        $query_result["sizes"] = getSizesQuantity($query_result["product_id"]);
        $products[] = $query_result;

    }
    return $products;
}


function getSizesQuantity ($product_id){
    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );

    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $size = $pdo->prepare("SELECT s.size_number ,s.size_quantity FROM pantofka.products as p JOIN sizes as s ON p.product_id = s.product_id WHERE p.product_id= ? " );
    $size->execute(array($product_id));
    $sizes=[];
    While ($result = $size->fetch(PDO::FETCH_ASSOC)){
        $sizes[]=$result;
    }
    return $sizes;

}


function sizeExists($product_name, $product_color , $material , $style, $subcategory, $size_number){

    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );
    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $query = $pdo->prepare('SELECT count(*) as size_exists FROM pantofka.products as p JOIN sizes as s ON p.product_id = s.size_id WHERE (p.product_name = ?  AND p.product_color= ?  AND p.material= ?  AND p.style= ?  AND p.subcategory= ? AND s.size_number = ?)');
    $query->execute(array($product_name,  $product_color , $material , $style, $subcategory, $size_number));
    $query_result = $query->fetch(PDO::FETCH_ASSOC);
    return boolval($query_result["size_exists"]);
}
