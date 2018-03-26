<h1>The product is already exist, please check the details and try again</h1>
<form action="index.php" method="post" enctype="multipart/form-data">
    Product name: <input type="text" name="product_name" placeholder="product name" required> <br>
    Product size: <input type="number" name="product_size" placeholder="size" min="20" max="50" required> <br>

    <select name="product_color" required>
        <option value="white">White</option>
        <option value="black">Black</option>
        <option value="brown">Brown</option>
        <option value="blue">Blue</option>
        <option value="red">Red</option>
        <option value="pink">Pink</option>
        <option value="green">Green</option>

    </select>
    <br>
    <select name="material">
        <option value="leather">Leather</option>
        <option value="canvas">Canvas</option>
        <option value="rubber">Rubber</option>
        <option value="eco-leather">Eco leather</option>
        <option value="synthetic">Synthetic</option>

    </select>
    <br>
    <select name="product_style">
        <option value="boots">Boots</option>
        <option value="sandals">Sandals</option>
        <option value="hills">Hills</option>
        <option value="casual">Casual</option>
        <option value="athletic">Athletic</option>
    </select>
    <br>
    <select name="subcategory">
        <option value="women">Women</option>
        <option value="men">Men</option>
        <option value="boys">Boys</option>
        <option value="girls">Girls</option>
    </select>
    <br>
    Product price: <input type="number" name="product_price" placeholder="price" required> <br>
    Is it on promotion? <input type="checkbox" name="on_promotion"  > <br>
    <input type="number" name="price_on_promotion"> <br>
    Is it a new product? <input type="checkbox" name="new_product"> <br>
    Quantity: <input type="number" name="quantity" placeholder="quantity">
    Product image<input type="file" name="picture_url" accept="image/*">
    <input type="submit" name="add_product" value="Add product">
</form>