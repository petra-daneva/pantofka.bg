<section>

    <?php if(isset($_SESSION["favorites"]) && !empty($_SESSION["favorites"])): ?>


        <table class="bottom-30 clear center">
            <tr  class="bottom-30 clear center aside-5">

                <th class="aside-5">Image</th>
                <th class="aside-5">Product name</th>
                <th class="aside-5">Product color </th>
                <th class="aside-5"> Material </th>
                <th class="aside-5">Shoe type</th>
                <th class="aside-5">Price</th>
                <th class="aside-5">Size</th>

            </tr>
            <?php

            foreach ($favorites_items as $item_no=>$item_data) {
                $product_id = $item_data["product_id"];
                $picture_link = "./assets/products_imgs/" . $item_data["product_img_name"];
                ?>
                <tr class='center'>

                    <td class="aside-5"><a href='index.php?page=product_info&product_id=<?= $product_id ?>'  class='clear_link'> <img
                                    src=<?= $picture_link ?> class='icon_img'> </a></td>
                    <td class="aside-5"><?= $item_data["product_name"] ?></td>
                    <td class="aside-5"><?= $item_data["product_color"] ?> </td>
                    <td class="aside-5"><?= $item_data["material"] ?> </td>
                    <td class="aside-5"><?= $item_data["style"] ?></td>
                    <td class="aside-5"><?php if ($item_data["sale_info_state"] === "sale") {
                            echo $item_data["sale_price"];
                        } else {
                            echo $item_data["product_price"];
                        } ?>  </td>
                    <td class="aside-5"><?= $item_data["size"] ?></td>


                    <td class='black'><a href='index.php?page=favorites&remove_favorites=<?=$item_no?>'> REMOVE </a></td>
                    <td class='black'><a href='index.php?page=favorites&move_to_cart=<?= $item_no ?>&size=<?= $item_data["size"] ?>&product_id=<?= $item_data["product_id"] ?>'>
                            MOVE TO CART </a></td>

                </tr>

                <?php
            }
            ?>
        </table>

        <?php ;else: ?>
        <h1> Looks like you don't have favorite products yet. Go ahead and add something!!</h1>
    <?php endif; ?>

</section>