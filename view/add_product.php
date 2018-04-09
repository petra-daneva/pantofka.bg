<?php
setcookie("add_to_subcategory", $_GET["subcategory"])?>

<h1 class="error center"> <?= isset($_COOKIE["error"])?htmlentities($_COOKIE["error"]):"" ?> </h1>

<section class="centered-section">
    <div id="add_product">
       <h2> Add product for category:</h2>
        <a href="index.php?page=add_product&subcategory=women">WOMEN</a>
        <a href="index.php?page=add_product&subcategory=men">MEN</a>
        <a href="index.php?page=add_product&subcategory=girls">GIRLS</a>
        <a href="index.php?page=add_product&subcategory=boys">BOYS</a>
        <br>

        <form action="index.php" method="post" enctype="multipart/form-data">
            Product subcategory : <?= $_GET["subcategory"] ?> <br>


            Product name: <input type="text" name="product_name" placeholder="product name" required> <br>

            Select product color: <select name="product_color" required>
                <option value="white">White</option>
                <option value="black">Black</option>
                <option value="brown">Brown</option>
                <option value="blue">Blue</option>
                <option value="red">Red</option>
                <option value="pink">Pink</option>
                <option value="green">Green</option>

            </select>
            <br>
            Select product material <select name="material">
                <option value="leather">Leather</option>
                <option value="canvas">Canvas</option>
                <option value="rubber">Rubber</option>
                <option value="eco-leather">Eco leather</option>
                <option value="synthetic">Synthetic</option>

            </select>
            <br>
            Select product style:  <select name="style">
                <option value="boots">Boots</option>
                <option value="sandals">Sandals</option>
                <option value="hills">Hills</option>
                <option value="casual">Casual</option>
                <option value="athletic">Athletic</option>
            </select>
            <br>
            Sale status:
            <select name="sale_info_state" id="">
                <option value="normal">Normal</option>
                <option value="new">New product</option>
            </select>
            <br>

            <?php
            $min_size = 0;
            $max_size = 0;


            if (!isset($_GET["subcategory"])){ // Chupi se kogato se dostypi samo add_product rychno, za tova mu slagam default-na stoinost
                header("location: index.php?page=add_product&subcategory=women");
            }else{
                if ($_GET["subcategory"] === "girls" || $_GET["subcategory"] === "boys"){
                    $min_size = 25;
                    $max_size = 34;
                }
                elseif ($_GET["subcategory"] === "women"){
                    $min_size = 35;
                    $max_size = 42;
                }
                elseif ($_GET["subcategory"] === "men"){
                    $min_size = 40;
                    $max_size = 48;
                }
            }
            for ($i = $min_size; $i <= $max_size; $i ++){
                ?>
                Size : <?= $i ?>  Quantity: <input type="number" name="<?= $i ?>" min="0" max="100" required>
                <br>
                <?php

            }

            ?>


            Product price: <input type="number" name="product_price" placeholder="price" required> <br>
            Product image<input type="file" name="product_img_name" accept="image/*"><br>
            <input type="submit" name="add_product" value="Add product">
        </form>
    </div>
</section>