<?php
if (isset($_GET["product_id"])) {

    $product = getProductData($_GET["product_id"]);
    $product["sizes"] = getSizesQuantity($_GET["product_id"]);
    if (isset($product["product_name"])) {
        $img_src = "./view/../assets/products_imgs/" . $product['product_img_name'];
        ?>

        <div class="product_info">
            <div class="img">
                <img src=  <?= $img_src ?> alt="Picture of the product">

            </div>
            <div class="info_block">
                <div class="name">
                    <h3><?= $product["product_name"] ?></h3><br>
                </div>
                <div class="info">
                    <h5>Product type: <?= $product["style"] ?></h5>
                </div>
                <div class="info">
                    <h5>Product color <?= $product["product_color"] ?></h5>
                </div>
                <div class="info">
                    <h5>Product material: <?= $product["material"] ?></h5><br>
                </div>
                <div class="prices">

                    <?php
                    if ($product["sale_info_state"] === "sale") {
                        ?>
                        <h5> Was <span class="line-trough"> <?= $product["product_price"] ?></span> Now: <span
                                    class="prices"> <?= $product["sale_price"] ?></span> levs </h5>
                        <?php
                    } else {
                        ?>
                        <h5> Price: <span class="prices "> <?= $product["product_price"] ?> levs</span></h5>
                        <?php
                    }
                    ?>
                </div>

                <form action="" method="post">

                    <div class="info">
                        <h6 class="sizes">Size: </h6>
                        <select class="sizes" style="display: inline-block" name="size" id="">
                            <?php
                            $total_quantity = 0;
                            foreach ($product["sizes"] as $size){
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
                            ?> <h6 class="price">Product is out of stock!</h6>  <?php
                        }
                        else{
                            ?>
                            <h6 class="price">&nbsp</h6>
                            <?php

                        }?>
                    </div>
                    <br>

                    <input type="hidden" name="product_id" value="<?= $product["product_id"] ?>">
                    <input type="hidden" name="product_img_name" value="<?= $product["product_img_name"] ?>">
                    <div class="div_buttons">
                        <input class="buttons" type="submit" name="add_to_cart" value="Add to cart">
                        <input class="buttons" type="submit" name="add_to_favorites" value="Add to favorites">

                    <?php

                    if (isset($_SESSION["logged_user"])) {
                        if ($user_info["is_admin"] === "1") {
                            ?>
                            <input class="buttons" type="submit" name="edit_product" value="Edit product">
                            <input class="buttons" type="submit" name="delete_product" value="Delete product">
                    </div>
                            <?php
                        }
                    }

                    ?>

                </form>
            </div>

        </div>
        <?php
    } else {
        ?>
        <H1>The product you are looking for does not exists!</H1>
        <?php
    }
} else {
    ?>
    <H1>Not selected product!</H1>
    <?php
}
?>