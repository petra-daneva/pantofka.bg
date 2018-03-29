<form action="index.php?products=result" method="POST">


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
    <br>
    <input type="number" name="size_number" placeholder="number">
    <br>
    <select name="order" >
        <option value="DESC"> Descending price </option>
        <option value="ASC">  Ascending price</option>

    </select>
    <input type="submit" name="search_data_advanced" value="Search">
</form>