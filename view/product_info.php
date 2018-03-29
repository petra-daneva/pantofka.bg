
<?php
if (isset($_GET["product_id"])) {

    $product = getProductData($_GET["product_id"]);
    $product["sizes"] = getSizesQuantity($_GET["product_id"]);
    $img_src = "./view/../assets/products_imgs/" . $product['product_img_name'];
    ?>

    <div class="product_info">
        <div class="img">
            <img src=  <?= $img_src ?> alt="Picture of the product">

        </div>
        <div class="name">
            <h3><?= $product["product_name"] ?></h3>
        </div>
        <div class="info">
            <h4>Product type: <?= $product["style"] ?></h4>
        </div>
        <div class="info">
            <h4>Product color <?= $product["product_color"] ?></h4>
        </div>
        <div class="info">
            <h4>Product material: <?= $product["material"] ?></h4>
        </div>
        <div class="prices">

            <?php
            if ($product["sale_info_state"] === "sale") {
                ?>
                <h3> Was <span class="line-trough"> <?= $product["product_price"] ?></span> Now: <span
                            class="prices"> <?= $product["sale_price"] ?></span> levs </h3>
                <?php
            } else {
                ?>
                <h3> Price: <span class="prices "> <?= $product["product_price"] ?> levs</span></h3>
                <?php
            }
            ?>
        </div>

        <form action="" method="post">

            <div>
                Choose Size:
                <select name="size" id="">
                    <?php
                    foreach ($product["sizes"] as $size) {

                        if ($size["size_quantity"] > 0): ?>
                            <option value="<?= $size["size_number"] ?>"> <?= $size["size_number"] ?> </option>
                        <?php endif;
                    }

                    ?>
                </select>
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
    <?php
}
else{
    ?>
<H1>Not selected product!</H1>
<?php
}
?>