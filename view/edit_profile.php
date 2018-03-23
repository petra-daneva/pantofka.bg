<?php if (isset($_COOKIE["message"])): ?>

    <h1 class="success center"> <?= htmlentities($_COOKIE["message"]); ?> </h1>

    <?php
var_dump($_COOKIE);
    $first_name = htmlentities($_COOKIE["first_name"]);

    $last_name = htmlentities($_COOKIE["last_name"]);

    $gender = htmlentities($_COOKIE["gender"]);

    $email = htmlentities($_COOKIE["email"]);

endif;
?>

<form action="index.php" method="post">

            <input type="text" name="first_name" placeholder="First name" value="<?= (empty($first_name))?($user_info["user_fname"]):($first_name) ?> " required> <br>

            <input type="text" name="last_name" placeholder="Last name" value="<?= (empty($last_name))?$user_info["user_lname"]:$last_name ?>" required> <br>

            <select name="gender" required>

                <option value="m" selected=<?php ($user_info["user_gender"] === "m" )?"selected":""; ?> >Male</option>

                <option value="f" selected=<?php ($user_info["user_gender"] === "f" )?"selected":""; ?> >Female</option>

            </select><br>

            <input type="email" name="email" value="<?= empty($email)?$logged_email:$email ;?>" placeholder="Email" required> <br>

            <input type="password" name="password_old" placeholder="Old password" required> <br>

            <input type="password" name="password_repeat" placeholder="Repeat password" required> <br>

            <input type="password" name="password_new" placeholder="New password (additional)"> <br>

            <input type="submit" name="save_profile_button" value="Save changes">

</form>



<?php

setcookie("message");

setcookie("first_name" );

setcookie("last_name");

setcookie("gender");

setcookie("email" );

$message = "";

$first_name = "";

$last_name = "";

$gender = "";

$email = "";

?>