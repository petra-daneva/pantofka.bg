<?php
//var_dump($search_by_name_str);
//var_dump($search_by_material_str);
//var_dump($advanced_search_result);
?>
<section>

    <?php if (!empty($advanced_search_result)){


        ?>

    <h1 class="error center"><?= $nested_error ?></h1>
        <h1>Search results</h1>
        <div class="search_page">
            <div class="show_products">
                <?php
                foreach ($advanced_search_result as $item) {

                    $product = getProductData($item["product_id"]);

                    $img_src = "./view/../assets/products_imgs/" . $product['product_img_name'];
                    ?>

                    <div class="shown_searched_products">
                        <div class="product_img">
                            <a id="show_product"
                               href="index.php?page=product_info&product_id=<?= $product["product_id"] ?>">
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
                                if ($total_quantity == 0) {
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

                    <?php
                }
                ?>
            </div>
        </div>

        <?php


    }
    elseif(!empty($search_by_results)){
?>


            <h1 class="error center"><?= $nested_error ?></h1>
            <h1>Search results</h1>
            <div class="search_page">
                <div class="show_products">
                    <?php
                    foreach ($search_by_results as $result) {

                        $product = getProductData($result["product_id"]);

                        $img_src = "./view/../assets/products_imgs/" . $product['product_img_name'];
                        ?>

                        <div class="shown_searched_products">
                            <div class="product_img">
                                <a id="show_product"
                                   href="index.php?page=product_info&product_id=<?= $product["product_id"] ?>">
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
                                    if ($total_quantity == 0) {
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

                        <?php
                    }
                    ?>
                </div>
            </div>

            <?php


    }

    else{
            ?>
            <h1 class="error">Nothing found</h1>
        <?php
    }
    ?>

</section>

