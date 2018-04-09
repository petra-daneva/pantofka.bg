<!-- -------------------------- Whole section wrapper --------------------------------->
<section class="inline_block" style="width: 100%">

        <!-- -------------------------- Products & Search --------------------------------->

        <!-- -------------------------- Search column --------------------------------->
        <div class="left">
            <?php require_once "search.php"; ?>
        </div>

        <!-- -------------------------- Displaying products here --------------------------------->

            <!-- -------------------------- Product boxes --------------------------------->
            <?php if (!empty($products)){ ?>
                <h1 class="error center"><?= $nested_error ?></h1>
                <h1>Search results</h1>
            <?php
                $advanced_search = true;
                require_once "display_products.php";
            ?>
            <?php }else{ ?>
                <h5 class="error center">Nothing was found</h5>
            <?php } ?>

            <!-- -------------------------- END Products & Search --------------------------------->
    </div>
    <!-- END Section Wrapper-->
</section>
