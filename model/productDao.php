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

function  changeProduct($product_id, $product_name, $product_color, $material, $style , $subcategory , $product_price, $sale_info_state, $product_img_name, $sale_price, $sizes, $new_size ){

    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS, PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = $pdo -> prepare('UPDATE pantofka.products SET product_name =?, product_color = ?, material = ?, style = ?, subcategory = ?, product_price =?, sale_info_state = ?, product_img_name =?, sale_price = ? WHERE product_id = ?');
    $query->execute(array($product_name, $product_color, $material, $style, $subcategory, $product_price, $sale_info_state, $product_img_name, $sale_price, $product_id));

    foreach ($sizes as $size){
        $size_number = $size["size_number"];
        $size_quantity = $size["size_quantity"];
        $query = $pdo -> prepare('UPDATE pantofka.sizes SET  size_quantity = ? WHERE size_number = ? AND product_id = ?');
        $query->execute(array($size_quantity, $size_number, $product_id));
    }
    if ($new_size){
        $size_number=$new_size["size_number"];
        $size_quantity = $new_size["size_quantity"];
        $query = $pdo->prepare('INSERT INTO sizes (size_number, size_quantity, product_id) Values (?, ?, ?)');
        $query->execute(array($size_number, $size_quantity, $product_id));
    }

}

function saveSize($product_name, $size_number, $size_quantity, $product_color , $material , $style, $subcategory)
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


/**
 * This function returns an array containing product_img_name , product_id , product_name , product_color , material, style , product_price of
 * specific product (! ONE PRODUCT !) by given its id. If the id does not exists in db the function will return false.
 *
 * @param $product_id String
 * @return mixed Array or False
 */
function getProductData($product_id){
    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );
    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $query = $pdo->prepare("SELECT product_img_name , product_id , product_name , product_color , material, style , product_price  FROM pantofka.products WHERE product_id = ?");
    $query->execute(array($product_id));
    $query_result = $query->fetch(PDO::FETCH_ASSOC);
    return $query_result;
}

/**
 * Insert an row in orders table. Missing sizes. Returns nothing.
 * @param $items_to_buy array with product id and size
 * @param $user_id
 */
function setOrder($items_to_buy , $user_id){
    require_once "././model/dbmanager.php";
    $pdo = new PDO(PDO_CONNECTION_DNS , PDO_CONNECTION_USERNAME, PDO_CONNECTION_PASSWORD );
    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    foreach ($items_to_buy as $item){
        $product_id = $item["product_id"];
        $product_size = $item["product_size"];

        $query = $pdo->prepare("INSERT INTO pantofka.orders (user_id ,date, size_id , product_id) 
        VALUES ( ?  , ? , (SELECT s.size_id FROM pantofka.sizes as s WHERE (s.size_number = ? && product_id = ?)) , ? );");
        $query->execute(array($user_id , date('Ymdhis') , $product_size ,$product_id , $product_id));
    }
}
