<div id="login-form">

        <?php if (isset($_COOKIE["error"]) || isset($_COOKIE["message"])): ?>

            <h1 class="error center"> <?= isset($_COOKIE["error"])?htmlentities($_COOKIE["error"]):""; ?> </h1>
            <h1 class="message center"> <?= isset($_COOKIE["message"])?htmlentities($_COOKIE["message"]):""; ?> </h1>

        <?php
            $email = htmlentities($_COOKIE["email"]);
                endif;
        ?>



        <form action="index.php" method="post" class="bottom-30">

            <input type="email" name="email" placeholder="Email" value="<?= empty($email)?'':$email ?>" required> <br>

            <input type="password" name="password" placeholder="Password" required> <br>

            <input type="submit" name="login_button" value="Log in">

        </form>

    <a href="index.php?page=register">In case you don't have a profile yet!</a>

</div>

<?php

    setcookie("error");

    setcookie("message");

    setcookie("email");

    $error = "";

    $email = "";

?>