<div id="add_product">
    <form action="index.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name= "product_id" value="<?= $_SESSION["edit_product"]["product_id"] ?>">
        Product name: <input type="text" name="product_name" value="<?= $_SESSION["edit_product"]["product_name"] ?>" required> <br>


        Product color : <select name="product_color" required>
            <option value="white" selected=<?php ($_SESSION["edit_product"]["product_color"] === "white" )?"selected":""; ?> >White</option>
            <option value="black" selected=<?php ($_SESSION["edit_product"]["product_color"] === "black" )?"selected":""; ?> >Black</option>
            <option value="brown" selected=<?php ($_SESSION["edit_product"]["product_color"] === "brown" )?"selected":""; ?> >Brown</option>
            <option value="blue" selected=<?php ($_SESSION["edit_product"]["product_color"] === "blue" )?"selected":""; ?> >Blue</option>
            <option value="red" selected=<?php ($_SESSION["edit_product"]["product_color"] === "red" )?"selected":""; ?> >Red</option>
            <option value="pink" selected=<?php ($_SESSION["edit_product"]["product_color"] === "pink" )?"selected":""; ?> >Pink</option>
            <option value="green" selected=<?php ($_SESSION["edit_product"]["product_color"] === "green" )?"selected":""; ?> >Green</option>

        </select>
        <br>
        Product material :
        <select name="material">
            <option value="leather" selected=<?php ($_SESSION["edit_product"]["material"] === "leather" )?"selected":""; ?>>Leather</option>
            <option value="canvas" selected=<?php ($_SESSION["edit_product"]["material"] === "canvas" )?"selected":""; ?>>Canvas</option>
            <option value="rubber" selected=<?php ($_SESSION["edit_product"]["material"] === "rubber" )?"selected":""; ?>>Rubber</option>
            <option value="eco-leather" selected=<?php ($_SESSION["edit_product"]["material"] === "eco-leather" )?"selected":""; ?>>Eco leather</option>
            <option value="synthetic" selected=<?php ($_SESSION["edit_product"]["material"] === "synthetic" )?"selected":""; ?>>Synthetic</option>

        </select>
        <br>
        Product style :
        <select name="style">
            <option value="boots" selected=<?php ($_SESSION["edit_product"]["style"] === "boots" )?"selected":""; ?>>Boots</option>
            <option value="sandals" selected=<?php ($_SESSION["edit_product"]["style"] === "sandals" )?"selected":""; ?>>Sandals</option>
            <option value="hills" selected=<?php ($_SESSION["edit_product"]["style"] === "hills" )?"selected":""; ?>>Hills</option>
            <option value="casual" selected=<?php ($_SESSION["edit_product"]["style"] === "casual" )?"selected":""; ?>>Casual</option>
            <option value="athletic" selected=<?php ($_SESSION["edit_product"]["style"] === "athletic" )?"selected":""; ?>>Athletic</option>
        </select>
        <br>
        Product subcategory :
        <select name="subcategory">
            <option value="women" selected=<?php ($_SESSION["edit_product"]["subcategory"] === "women" )?"selected":""; ?>>Women</option>
            <option value="men" selected=<?php ($_SESSION["edit_product"]["subcategory"] === "men" )?"selected":""; ?>>Men</option>
            <option value="boys" selected=<?php ($_SESSION["edit_product"]["subcategory"] === "boys" )?"selected":""; ?>>Boys</option>
            <option value="girls" selected=<?php ($_SESSION["edit_product"]["subcategory"] === "girls" )?"selected":""; ?>>Girls</option>
        </select>
        <br>
        The sale info state :
        <select name="sale_info_state" id="">
            <option value="normal" selected=<?php ($_SESSION["edit_product"]["sale_info_state"] === "normal" )?"selected":""; ?>>Normal</option>
            <option value="new" selected=<?php ($_SESSION["edit_product"]["sale_info_state"] === "new" )?"selected":""; ?>>New product</option>
            <option value="sale" selected=<?php ($_SESSION["edit_product"]["sale_info_state"] === "sale" )?"selected":""; ?>>Product on SALE</option>
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
        $i=0;
        foreach ($_SESSION["edit_product"]["sizes"] as $size){
            ?>
            Size : <?= $size["size_number"] ?>  Quantity: <input type="number" name="<?=$i?>" value="<?= $size["size_quantity"]?>">
            <br>
            <?php
        }
        ?>
        Add new size: <input type="number" name="new_size">
        Quantity: <input type="number" name="new_quantity"> <br>


        <input type="submit" name="change_product" value="Change product">

    </form>
</div>