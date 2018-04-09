<section class="left-section">
    <div id="search_forms">

    <form action="index.php?page=search" method="post">
        <input type="text" name="search_bar_input" placeholder="Search here" >
        <input type="submit" name="search_bar_button" value="Go!">
    </form>


    <form action="index.php?page=search_result" method="POST">
        <div  class="column inline_block">
        <?php
            $characteristic = ["colors"=>$all_colors , "materials"=>$all_materials , "subcategory" => $all_subcategories ,"styles" => $all_styles ,"sale_info_state" => $all_collections  ,"sizes" => $all_sizes];
                foreach ($characteristic as $characteristic_name => $all_values){ ?>
                    <fieldset>
                        <legend>Choose <?= $characteristic_name ?></legend>
                        <?php

                        foreach ($all_values as $this_value){
                            $value =  $this_value[key( $this_value)];
                            ?>
                        <div>
                            <input type="checkbox" id="<?=  $value  ?>" name= <?= $characteristic_name."[$value]" ?> value="<?=  $value  ?>">
                            <label for="<?= $value  ?>"><?=  $value  ?></label>
                        </div>
                        <?php } ?>

                    </fieldset>
                     <?php } ?>
                    <fieldset>
                        <legend>Price interval</legend>
                        MIN <input type="number" name="users_sup_price" value=<?= $sup_price ?> min=<?= $sup_price ?> max=<?= $inf_price ?> > <br>
                        MAX<input type="number" name="users_inf_price" value=<?= $inf_price ?> min=<?= $sup_price?> max=<?= $inf_price?> > <br>

                    </fieldset>
                <br>
                <input type="submit" name="advanced_search" value="Filter">
                </div>
    </form>


    </div>

</section>
