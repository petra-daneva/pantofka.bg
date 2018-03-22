<?php

require_once "./view/../controller/productsController.php"
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./view/../assets/default.css">
    <title>Document</title>
</head>
<body>

<div class="products_page" >

    <div class="page_title">
        <h3 class="page_title">Women's page</h3>
    </div>
    <div class="show_products">
        <?php
        foreach ($products as $product) {
            if ($product["subcategory"] === "women"){
                ?>
                <div class="shown_products">
                    <div class="product_img">
                        <img src="./view/../assets/products_imgs/<?= $product["product_img_name"] ?>" alt="picture of the product">
                    </div>
                    <div class="product_name">
                        <h3><?= $product["product_name"] ?></h3>
                    </div>
                    <div class="product_type">
                        <h4>Product type: <?= $product["product_style"] ?></h4>
                    </div>
                    <div class="product_type">
                        <h4>Product color <?= $product["product_color"] ?></h4>
                    </div>
                    <div class="product_type">
                        <h4>Product material: <?= $product["material"] ?></h4>
                    </div>
                    <div class="price">
                        <h3>Price: <?= $product["product_price"] ?> leva</h3>
                    </div>
                    <form action=index.php?products=women method="post">

                        <input type="hidden" name="product_id" value="<?= $product["product_id"] ?>">

                        <input class="buttons" type="submit" name="add_to_cart" value="Add to cart">
                        <input class="buttons" type="submit" name="add_to_favourites" value="Add to favourites">
                    </form>

                </div>

                <?php
            }
        }
        ?>
    </div>

</div>
</body>
</html>