<div class="centered-section form-page min-height-400">
<?php
if (isset($_SESSION["logged_user"])) {
    ?>

    <div class="form">

        <h3>Hello, <?= $user_info["user_fname"] ?></h3>

        <form action="index.php" method="post">

            <input type="text" name="first_name" placeholder="First name"
                   value="<?= (empty($first_name)) ? ($user_info["user_fname"]) : ($first_name) ?>" required> <br>

            <input type="text" name="last_name" placeholder="Last name"
                   value="<?= (empty($last_name)) ? $user_info["user_lname"] : $last_name ?>" required> <br>

            <select name="gender" required>

                <option value="m" <?php if ($user_info["user_gender"] === "m") { ?> selected <?php } ?> >Male</option>

                <option value="f" <?php if ($user_info["user_gender"] === "f") { ?> selected <?php } ?> >Female</option>

            </select><br>

            <input type="email" name="email" value="<?= empty($email) ? $logged_email : $email; ?>" placeholder="Email"
                   required> <br>

            <input type="password" name="password_old" placeholder="Old password" required> <br>

            <input type="password" name="password_repeat" placeholder="Repeat password" required> <br>

            <input type="password" name="password_new" placeholder="New password (additional)"> <br>

            <input class=button type="submit" name="save_profile_button" value="Save changes">

        </form>

    </div>
    <?php
} else {
    ?>
    <h5>Looks like you are not logged in ... </h5> <a href="index.php?page=login">Log in here!</a>
    <?php
}
?>

</div>


