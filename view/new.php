<div class="products_page" >

    <div class="page_title">
        <h3 class="page_title">NEW products</h3>
    </div>
    <div class="show_products">
        <?php

        foreach ($products as $product) {
            if ($product["sale_info_state"] === "new"){
                ?>
                <div class="shown_products">
                    <div class="product_img">
                        <img src="./view/../assets/products_imgs/<?= $product["product_img_name"] ?>" alt="picture of the product">
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
                        <h3>Price: <?= $product["product_price"] ?> levs</h3>
                    </div>
                    <form action=index.php?products=new method="post">
                        <div>
                            <?php
                            foreach ($product["sizes"] as $size) {
                                if ($size["size_quantity"] >0) {


                                    ?>
                                    <?= $size["size_number"] ?><input type="radio" name="size" value="<?= $size["size_number"]?>">

                                    <?php
                                }
                            }
                            ?>
                        </div>

                        <input type="hidden" name="product_id" value="<?= $product["product_id"] ?>">

                        <input class="buttons" type="submit" name="add_to_cart" value="Add to cart">
                        <input class="buttons" type="submit" name="add_to_favourites" value="Add to favourites">
                        <?php
                        if  ($user_info["is_admin"] == 1) {
                            ?>
                            <input class="buttons" type="submit" name="edit_product" value="Edit product">
                            <input class="buttons" type="submit" name="delete_product" value="Delete product">
                            <?php
                        }
                        ?>
                    </form>

                </div>

                <?php
            }
        }
        ?>
    </div>