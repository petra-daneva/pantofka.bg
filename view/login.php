<div id="login-form">

        <?php if (isset($_COOKIE["error"])): ?>

            <h1 class="error center"> <?= htmlentities($_COOKIE["error"]); ?> </h1>

        <?php
            $email = htmlentities($_COOKIE["savedData"]);
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

    setcookie("savedData");

    $error = "";

    $email = "";

?>