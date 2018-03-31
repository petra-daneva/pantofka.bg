<section class="inline_block">
    <div id="search_forms"  class="inline_block border left">

    <form action="index.php?page=search" method="post">
        <input type="text" name="search_bar_input" placeholder="search for item name" >
        <input type="submit" name="search_bar_button" value="Search">
    </form>


    <form action="index.php?page=search" method="POST">
        <div  class="inline_block top-30 bottom-30 aside-5 border left">
        <?php
            $characteristic = ["colors"=>$all_colors , "materials"=>$all_materials , "subcategory" => $all_subcategories ,"styles" => $all_styles ,"sale_info_state" => $all_collections];
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
                     <?php }  ?>
                <br>
                <input type="submit" name="advanced_search" value="Search">
                </div>
    </form>

    </div>

    <div id="result_from_search" class="inline_block top-30 bottom-30 aside-5 width_auto border">
        <?php require_once "search_result.php"; ?>
    </div>

</section>