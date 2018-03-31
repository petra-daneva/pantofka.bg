<section>

    <h1 class="error center"><?= $nested_error ?></h1>

    <?php if(!empty($advanced_search_result)):  ?>
        <h1>Search results</h1>
        <?php
        foreach ($advanced_search_result as $item) {
            $id = $item["product_id"];
            $img = $item["product_img_name"];
            echo "<a href='index.php?page=product_info&product_id=$id' target='_blank' class='clear_link inline_black left'><img src='./view/../assets/products_imgs/$img' class='icon_img inline_black left'></a>";
            }
        ?>
    <?php ;elseif(!empty($search_by_results)):
        foreach ($search_by_results as $item) {
            echo var_dump($item);
            echo "<br>";
        }
         endif; ?>
</section>