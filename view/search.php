<form action="index.php?page=search_result" method="post">

    <input type="text" name="search_bar_input" placeholder="search for keywords" >
    <input type="submit" name="search_bar_button" value="Search">

</form>


<form action="index.php?page=search_result" method="POST">
<?php
$characteristic = ["colors"=>$all_colors , "materials"=>$all_materials , "subcategory" => $all_subcategories ,"styles" => $all_styles ,"collections" => $all_collections];
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

    <?php   }  ?>
    <input type="submit" name="advanced_search" value="Search">

</form>