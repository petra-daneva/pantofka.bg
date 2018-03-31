<?php


    $subcategory_name = htmlentities($_GET['products']);
    $name = str_replace("_" , " " , $subcategory_name);
 ?>


<div class="products_page" >

    <?php if( isset($_SESSION["logged_user"]) && $user_info["is_admin"] == 1 && ($subcategory_name === "women" || $subcategory_name === "men" || $subcategory_name === "girls" || $subcategory_name === "boys")): ?>

        <a id="link" href="index.php?page=add_product&subcategory=<?=$subcategory_name?>"><img src="assets/icons/add.png" id="add-product-icon">  Add product </a>

    <?php endif; ?>

    <div class="page_title">
        <h3 class="page_title"> <?= strtoupper($name) ?> products</h3>
    </div>

    <div class="show_products">
        <?php
        foreach ($products as $product) {
        $subcategory_sale_state = $product["sale_info_state"];

    if ($product["subcategory"] === $subcategory_name || $subcategory_sale_state === $subcategory_name):

    $img_src = "./view/../assets/products_imgs/" . $product['product_img_name'];
    ?>

    <div class="shown_products">
        <div class="product_img">
            <a id="show_product" href="index.php?page=product_info&product_id=<?= $product["product_id"] ?>">
                <img onclick="" src=  <?= $img_src ?> alt="Picture of the product">
            </a>
        </div>
        <div class="product_name">
            <h3><?= $product["product_name"] ?></h3>
        </div>
        <div class="product_type">
            <h4>Product type: <?= $product["style"] ?></h4>
        </div>
        <div class="product_type">
            <h4>Product color <?= $product["product_color"] ?></h4>
        </div>
        <div class="product_type">
            <h4>Product material: <?= $product["material"] ?></h4>
        </div>
        <div class="price">

            <?php
            if ($product["sale_info_state"] === "sale") {
                ?>
                <h3> Was <span class="line-trough"> <?= $product["product_price"] ?></span> Now: <span
                            class="price"> <?= $product["sale_price"] ?></span> levs </h3>
                <?php
            } else {
                ?>
                <h3> Price: <span class="price "> <?= $product["product_price"] ?> levs</span></h3>
                <?php
            }
            ?>
        </div>

        <form action="" method="post">

            <div>
                Choose Size:
                <select name="size" id="">
                    <?php
                    $total_quantity = 0;
                    foreach ($product["sizes"] as $size) {
                        $total_quantity = $total_quantity + $size["size_quantity"];
                        if ($size["size_quantity"] > 0) {
                            ?>
                            <option value="<?= $size["size_number"] ?>"> <?= $size["size_number"] ?> </option>
                        <?php }

                    }

                    ?>
                </select>
                <?php
                if ($total_quantity == 0){
                    ?>
                    <h3 class="price">Product is out of stock!</h3>

                    <?php
                }
                ?>
            </div>

            <input type="hidden" name="product_id" value="<?= $product["product_id"] ?>">
            <input type="hidden" name="product_img_name" value="<?= $product["product_img_name"] ?>">

            <input class="buttons" type="submit" name="add_to_cart" value="Add to cart">
            <input class="buttons" type="submit" name="add_to_favorites" value="Add to favorites">
            <?php

            if (isset($_SESSION["logged_user"])) {
                if ($user_info["is_admin"] === "1") {
                    ?>
                    <input class="buttons" type="submit" name="edit_product" value="Edit product">
                    <input class="buttons" type="submit" name="delete_product" value="Delete product">
                    <?php
                }
            }
            ?>

        </form>

    </div>

    <?php endif;
    } // End foreach
    ?>
</div>
</div>


<script>
    function showInfo(){
        alert(this.name);
    }

</script>
