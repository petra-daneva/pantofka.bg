<div id="add_product">
    <a href="index.php?products=out_of_stock"> Out of stock </a>
    <form action="index.php?page=main" method="post" enctype="multipart/form-data">
        Product name: <input type="text" name="product_name" value="<?= $_SESSION["edit_product"]["product_name"] ?>" required> <br>


        Product color : <select name="product_color" required>
            <option value="white" <?php if($_SESSION["edit_product"]["product_color"] === "white" ){?> selected <?php } ?> >White</option>
            <option value="black" <?php if($_SESSION["edit_product"]["product_color"] === "black" ){?> selected <?php } ?> >Black</option>
            <option value="brown" <?php if($_SESSION["edit_product"]["product_color"] === "brown" ){?> selected <?php } ?> >Brown</option>
            <option value="blue" <?php if($_SESSION["edit_product"]["product_color"] === "blue" ){?> selected <?php } ?> >Blue</option>
            <option value="red" <?php if($_SESSION["edit_product"]["product_color"] === "red" ){?> selected <?php } ?> >Red</option>
            <option value="pink" <?php if($_SESSION["edit_product"]["product_color"] === "pink" ){?> selected <?php } ?> >Pink</option>
            <option value="green" <?php if($_SESSION["edit_product"]["product_color"] === "green" ){?> selected <?php } ?> >Green</option>

        </select>
        <br>
        Product material :
        <select name="material">
            <option value="leather" <?php if($_SESSION["edit_product"]["material"] === "leather" ){?> selected <?php } ?>>Leather</option>
            <option value="canvas" <?php if($_SESSION["edit_product"]["material"] === "canvas" ){?> selected <?php } ?>>Canvas</option>
            <option value="rubber" <?php if($_SESSION["edit_product"]["material"] === "rubber" ){?> selected <?php } ?>>Rubber</option>
            <option value="eco-leather" <?php if($_SESSION["edit_product"]["material"] === "eco-leather" ){?> selected <?php } ?>>Eco leather</option>
            <option value="synthetic" <?php if($_SESSION["edit_product"]["material"] === "synthetic" ){?> selected <?php } ?>>Synthetic</option>

        </select>
        <br>
        Product style :
        <select name="style">
            <option value="boots" <?php if($_SESSION["edit_product"]["style"] === "boots" ){?> selected <?php } ?>>Boots</option>
            <option value="sandals" <?php if($_SESSION["edit_product"]["style"] === "sandals" ){?> selected <?php } ?>>Sandals</option>
            <option value="hills" <?php if($_SESSION["edit_product"]["style"] === "hills" ){?> selected <?php } ?>>Hills</option>
            <option value="casual" <?php if($_SESSION["edit_product"]["style"] === "casual" ){?> selected <?php } ?>>Casual</option>
            <option value="athletic" <?php if($_SESSION["edit_product"]["style"] === "athletic" ){?> selected <?php } ?>>Athletic</option>
        </select>
        <br>
        Product subcategory :
        <select name="subcategory">
                <option value="women" <?php if($_SESSION["edit_product"]["subcategory"] === "women"){?> selected <?php } ?>>Women</option>
                <option value="men" <?php if($_SESSION["edit_product"]["subcategory"] === "men" ){?> selected <?php } ?>>Men</option>
                <option value="boys" <?php if($_SESSION["edit_product"]["subcategory"] === "boys" ){?> selected <?php } ?>>Boys</option>
                <option value="girls" <?php if($_SESSION["edit_product"]["subcategory"] === "girls" ){?> selected <?php } ?>>Girls</option>
        </select>
        <br>
        The sale info state :
        <select name="sale_info_state" id="">
            <option value="normal" <?php if($_SESSION["edit_product"]["sale_info_state"] === "normal" ){ ?> selected <?php } ?>>Normal</option>
            <option value="new" <?php if($_SESSION["edit_product"]["sale_info_state"] === "new" ){ ?> selected <?php } ?>>New product</option>
            <option value="sale" <?php if($_SESSION["edit_product"]["sale_info_state"] === "sale" ){?> selected <?php } ?>>Product on SALE</option>
        </select>
        Price on sale <input type="number" name="sale_price" value="<?= $_SESSION["edit_product"]["sale_price"] ?>">
        <br>
        Product price:<input type="number" name="product_price"value="<?= $_SESSION["edit_product"]["product_price"] ?>" required> <br>
        <div  >
            <img width="200px" src="./view/../assets/products_imgs/<?= $_SESSION["edit_product"]["product_img_name"] ?>" alt="picture of the product">
        </div>
        <input type="hidden" name="product_img_name" value="<?= $_SESSION["edit_product"]["product_img_name"] ?>">
        Choose another image: <input type="file" name="product_img_name" accept="image/*"><br>



        <?php

     foreach ($_SESSION["edit_product"]["sizes"] as $size){
            ?>
            Size : <?= $size["size_number"] ?>  Quantity: <input type="number" name="<?= $size["size_number"] ?>" value="<?= $size["size_quantity"]?>">
            <br>
            <?php

        }

        ?>

          Add new size: <input type="number" name="new_size">-->
       Quantity: <input type="number" name="new_quantity"> <br>-->


        <input type="submit" name="change_product" value="Change product">

    </form>
</div>