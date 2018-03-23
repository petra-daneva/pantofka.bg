<nav class="clear right">
    <?php if($user_info["is_admin"] == 1): ?>

        <a href="index.php?page=add_product"><img src="assets/icons/add.png" id="add-product-icon">  Add product </a>

    <?php endif; ?>

        <a href="index.php?page=edit_profile">Edit profile</a>

        <a href="index.php?page=history">History</a>

        <a href="index.php?page=cart"> <img src="assets/icons/cart.png" id="cart-icon">CART</a>

        <a href="index.php?page=favorites"> <img src="assets/icons/favorite.png" id="favorite-icon"> FAVORITES </a>

        <a href="index.php?page=logout">Exit</a>

</nav>