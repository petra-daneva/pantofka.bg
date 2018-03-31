<?php
//var_dump($search_by_name_str);
//var_dump($search_by_material_str);
//var_dump($advanced_search_result);
?>
<section>

    <?php if(!empty($advanced_search_result)):  ?>
        <h1>Search results</h1>
        <?php
        foreach ($advanced_search_result as $item) {

            echo var_dump($item);
            echo "<br>";
            }
        ?>
    <?php ;elseif(!empty($search_by_results)):

        foreach ($search_by_results as $item) {

            echo var_dump($item);
            echo "<br>";
        }
        else:
        ?>
    <h1 class="error">Nothing found</h1>
    <?php endif; ?>
</section>

