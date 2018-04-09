<div class="show_products inline_block">
    <?php
    foreach ($products as $product):
        $subcategory_sale_state = $product["sale_info_state"];
        if(isset($advanced_search)){ // I know , i know...
            $subcategory_name = true;
        }
        if ($product["subcategory"] == $subcategory_name || $subcategory_sale_state == $subcategory_name):
            $img_src = "./view/../assets/products_imgs/" . $product['product_img_name'];
    ?>

    <div class="shown_products inline_block">
        <div class="product_img">
            <a id="show_product" href="index.php?page=product_info&product_id=<?= $product["product_id"] ?>">
                <img src=<?= $img_src ?> alt="Picture of the product">
            </a>
        </div>
        <div class="product_name">
            <h5><?= $product["product_name"] ?></h5>
        </div>
        <div class="product_type">
            <h6>Product type: <?= $product["style"] ?></h6>
        </div>
        <div class="product_type">
            <h6>Product color <?= $product["product_color"] ?></h6>
        </div>
        <div class="product_type">
            <h6>Product material: <?= $product["material"] ?></h6>
        </div>
        <div class="price">
            <?php
            if ($product["sale_info_state"] === "sale") {
                ?>
                <h6> Was <span class="line-trough"> <?= $product["product_price"] ?></span> Now: <span
                        class="price"> <?= $product["sale_price"] ?></span> levs </h6>
                <?php } else {  ?>
                <h6> Price: <span class="price "> <?= $product["product_price"] ?> levs</span></h6>
                <?php  } ?>
        </div>

        <form action="" method="post">

            <div class="product_type">
                <select style="display: inline-block" name="size" id="">
                <option value=""> Choose a size. . . </option>
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
                    }  ?>
            </div>
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
            <?php }
            } ?>
        </form>
    </div>
        <?php endif;
endforeach; ?>
</div>
