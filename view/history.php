<section>

    <?php if(!empty($orders_history)):  ?>

        <form action="index.php?page=history" method="post">

            <input type="text" name="search_history_input" placeholder="search for keywords" >
            <input type="submit" name="search_history_button" value="Search">

        </form>

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
            $load_count = 0;
            $history_count = 25;

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

        <?php ;else: ?>

        <h1>History is empty. Go ahead and buy something!!</h1>
    <?php endif; ?>

</section>
