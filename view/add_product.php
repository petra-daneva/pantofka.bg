<h1 class="error center"> <?= isset($_COOKIE["error"])?htmlentities($_COOKIE["error"]):"" ?> </h1>


<section>
    <div id="add_product">
        <form action="index.php" method="post" enctype="multipart/form-data">
            Product name: <input type="text" name="product_name" placeholder="product name" required> <br>
            Product size: <input type="number" name="size_number" placeholder="size" min="20" max="50" required> <br>
            Quantity: <input type="number" name="size_quantity" placeholder="quantity" min="0" max="50" required> <br>


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
            Select subcategory: <select name="subcategory">
                <option value="women">Women</option>
                <option value="men">Men</option>
                <option value="boys">Boys</option>
                <option value="girls">Girls</option>
            </select>
            <select name="sale_info_state" id="">
                <option value="normal">Normal</option>
                <option value="new">New product</option>
            </select>
            <br>
            Product price: <input type="number" name="product_price" placeholder="price" required> <br>
            Product image<input type="file" name="product_img_name" accept="image/*"><br>
            <input type="submit" name="add_product" value="Add product">
        </form>
    </div>
</section>