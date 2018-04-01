<section>

    <?php if(isset($_SESSION["cart"]) && !empty($_SESSION["cart"])): ?>

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

            $_SESSION["cart_price"] = 0;
            foreach ($cart_items as $item_no=>$item_data){
                if ($item_data["sale_info_state"]=== "sale"){
                    $_SESSION["cart_price"]+=$item_data["sale_price"];
                }
               else{
                   $_SESSION["cart_price"] += $item_data["product_price"];
               }
                $product_id = $item_data["product_id"];
                $picture_link = "./assets/products_imgs/" . $item_data["product_img_name"];
                ?>
                <tr class='center'>

                    <td class="aside-5"><a href='index.php?page=product_info&product_id=<?= $product_id ?>' target='_blank' class='clear_link'> <img
                                    src=<?= $picture_link ?> class='icon_img'> </a></td>                <td class="aside-5"><?= $item_data["product_name"]?></td>
                <td class="aside-5"><?= $item_data["product_color"]?> </td>
                <td class="aside-5"><?= $item_data["material"]?> </td>
                <td class="aside-5"><?= $item_data["style"]?></td>
                <td class="aside-5"><?php if ($item_data["sale_info_state"] === "sale"){ echo $item_data["sale_price"];}else {echo $item_data["product_price"];} ?>  </td>
                <td class="aside-5"><?= $item_data["size"]?></td>

                <td class='black'> <a href='index.php?page=cart&remove_cart=<?=$item_no?>'> REMOVE </a> </td>
             </tr>
<?php
            }

            ?>
        </table>

        <?php echo "Total: " .  $_SESSION["cart_price"]; ?>

        <?php if (isset($_SESSION["logged_user"])): ?>

            <form action="index.php" method="post">
                <input type="submit" name="buy_cart" value="Buy">
            </form>

            <?php ;else: ?>
            <a href="index.php?page=login">You must login to order!</a>

            <?php ;endif; ?>


        <?php ;else: ?>

        <h1>Cart is empty. Go ahead and add something!!</h1>
    <?php endif; ?>

