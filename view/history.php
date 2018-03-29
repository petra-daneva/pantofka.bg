<section>

    <?php if(!empty($orders_history)):  ?>

        <table class="bottom-30 clear center">

            <tr  class="bottom-30 clear center aside-5">

                <th class="aside-5">Date</th>
                <th class="aside-5">Product name</th>
                <th class="aside-5">Color </th>
                <th class="aside-5">Prize </th>
                <th class="aside-5">Style </th>
                <th class="aside-5">Category </th>
                <th class="aside-5"> Material </th>
                <th class="aside-5">Size </th>
                <th class="aside-5">Picture </th>


            </tr>

            <?php

            $load_count = 0; // counter for each item

            if (!isset($_GET["load_history"])){
                $history_count = 5; // items to show

            }else{
                if (count($orders_history) < 25){
                    $history_count = count($orders_history); // show all items in order history if their count is no greater than 25
                }else{
                    $history_count = 25; // else show only latest 25 TODO load all 
                    ?>
                    echo "<a href='index.php?page=history&load_history=all'>LOAD ALL!</a>";
                    <?php
                }

            }
            foreach ($orders_history as $order) {
                if ($load_count == $history_count) {
                    break;
                }
                $load_count++;
                $picture_link = "./assets/products_imgs/" . $order["product_img_name"];
                ?>
                <tr>
                    <td class="aside-5"><?= $order["date"] ?></td>
                    <td class="aside-5"><?= $order["product_name"] ?></td>
                    <td class="aside-5"><?= $order["product_color"] ?> </td>
                    <td class="aside-5"><?php if ($order["sale_info_state"] === "sale") {
                            echo $order["sale_price"];
                        } else {
                            echo $order["product_price"];
                        } ?>
                    </td>

                    <td class="aside-5"><?= $order["style"] ?></td>
                    <td class="aside-5"><?= $order["subcategory"] ?> </td>
                    <td class="aside-5"><?= $order["material"] ?> </td>
                    <td class="aside-5"><?= $order["size_number"] ?> </td>

                    <td><a href=<?= $picture_link ?>target='_blank' class='clear_link'> <img
                                    src=<?= $picture_link ?> class='icon_img'> </a></td>
                </tr>
                <!--//                echo "<tr>";-->
                <!--//                foreach ($order as $key=>$value){-->
                <!--//                   if ($key == "product_img_name"){-->
                <!--//                       $picture_link = "./assets/products_imgs/" . $value;-->
                <!--//                       echo "<td> <a href=$picture_link target='_blank' class='clear_link'> <img src=$picture_link class='icon_img'> </a> </td>";-->
                <!--//                       continue;-->
                <!--//                   }-->
                <!--//                   echo "<td> $value </td>";-->
                <!--//-->
                <!--//                }-->
                <!--            }-->
                <!--                echo "</tr>";-->
                <?php
            }
            ?>
        </table>


        <?php
            echo "<a href='index.php?page=history&load_history'>LOAD MORE!</a>";

                            ;else:
        ?>

        <h1>History is empty. Go ahead and buy something!!</h1>
    <?php endif; ?>

</section>
