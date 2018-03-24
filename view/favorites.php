<section>

    <?php if(isset($_SESSION["favorites"]) && !empty($_SESSION["favorites"])): ?>

        <table class="bottom-30 clear center">
            <tr  class="bottom-30 clear center aside-5">
                <th class="aside-5">Product name</th>
                <th class="aside-5">Product color </th>
                <th class="aside-5">Meterial </th>
                <th class="aside-5">Shoe type</th>
                <th class="aside-5">Price</th>
                <th class="aside-5">Image</th>

            </tr>
            <?php

            foreach ($favorites_items as $item_no=>$item_data){
                $picture_link = "./assets/products_imgs/" . $item_data["product_img_name"];
                echo "<tr class='center'>";

                foreach ($item_data as $title=>$info) {
                    if ($title === "product_id"){
                        $product_id = $info;
                        continue;
                    }
                    if ($title === "product_img_name"){
                        echo "<td> <a href=$picture_link target='_blank' class='clear_link'> <img src=$picture_link class='icon_img'> </a> </td>";
                        continue;
                    }
                    echo "<td>" . $info . "</td>";

                }
                echo "<td class='black'> <a href='index.php?page=favorites&remove_favorites=$item_no'> REMOVE </a> </td>";
                echo "<td class='black'> <a href='index.php?page=favorites&add_to_cart=$item_no&id=$product_id'> ADD TO CART </a> </td>";

                echo "</tr>";
            }

            ?>
        </table>

        <?php ;else: ?>
        <h1> Looks like you don't have favorite products yet. Go ahead and add something!!</h1>
    <?php endif; ?>

</section>