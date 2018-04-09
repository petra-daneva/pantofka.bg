<?php
$subcategory_name = htmlentities($_GET['products']);
$name = str_replace("_" , " " , $subcategory_name);
?>

<!-- -------------------------- Whole section wrapper --------------------------------->
<section class="inline_block" style="width: 100%">

    <!-- -------------------------- Headings --------------------------------->
    <div class="column">
            <span class="column">
                <?php
                // Admin feature here.
                if( isset($_SESSION["logged_user"]) && $user_info["is_admin"] == 1 && ($subcategory_name === "women" || $subcategory_name === "men" || $subcategory_name === "girls" || $subcategory_name === "boys")): ?>
                    <h6 class="inline_block left">
                        <a href="index.php?page=add_product&subcategory=<?=$subcategory_name?>" class=""> Add new product </a>
                    </h6>
                <?php endif; ?>
            </span>
        <!-- -------------------------- Page title --------------------------------->
        <span class="column center">
                <h3> <?= strtoupper($name) ?> products</h3>
            </span>
        <!-- -------------------------- Products & Search --------------------------------->

        <!-- -------------------------- Search column --------------------------------->
        <div class="left">
            <?php require_once "search.php"; ?>
        </div>

        <!-- -------------------------- Displaying products here --------------------------------->

        <!-- -------------------------- Product boxes --------------------------------->
        <?php require_once "display_products.php"; ?>
        <!-- -------------------------- END of product box --------------------------------->

        <!-- -------------------------- END Products & Search --------------------------------->
    </div>
    <!-- END Section Wrapper-->
</section>

