<?php if (isset($_COOKIE["error"]) || isset($_COOKIE["email_exists"])): ?>

    <h1 class="error center"> <?= isset($_COOKIE["error"])?htmlentities($_COOKIE["error"]):"" ?> </h1>
    <h1 class="error center"> <?= isset($_COOKIE["email_exists"])?htmlentities($_COOKIE["email_exists"]):"" ?> </h1>

    <?php

        $first_name = htmlentities($_COOKIE["first_name"]);

        $last_name = htmlentities($_COOKIE["last_name"]);

        $gender = htmlentities($_COOKIE["gender"]);

        $email = htmlentities($_COOKIE["email"]);

    endif;
?>

<div id="register-form">

        <form action="index.php" method="post" class="bottom-30">

            <input type="text" name="first_name" placeholder="First name" value="<?= empty($first_name)?'':$first_name ?>" required> <br>

            <input type="text" name="last_name" placeholder="Last name" value="<?= empty($last_name)?'':$last_name ?>"  required> <br>


            <select name="gender" required>

                <option value="m" <?= empty($gender)?'selected="selected"':'' ?>  >Male</option>

                <option value="f" <?= empty($gender)?'':((($gender)=='f')?'selected="selected"':'') ?> >Female </option>

            </select> <br>

            <input type="email" name="email" placeholder="Email" value="<?= empty($email)?'':$email ?>" required> <br>

            <input type="password" name="password" placeholder="Password" required> <br>

            <input type="password" name="password_repeat" placeholder="Repeat password" required> <br>

            <input type="submit" name="register_button" value="Register">

        </form>

    <a href="index.php?page=login">In case you already have a profile!</a>

</div>


<?php

    setcookie("error");

    setcookie("email_exists");

    setcookie("first_name" );

    setcookie("last_name");

    setcookie("gender");

    setcookie("email" );

    $error = "";

    $email_exists = "";

    $first_name = "";

    $last_name = "";

    $gender = "";

    $email = "";

?>