<?php if ($error || $email_exists): ?>

    <h1 class="error center"> <?= $error ?> </h1>
    <h1 class="error center"> <?= $email_exists ?> </h1>

<?php endif; ?>
<div class="form-page">
    <div class="form">

        <form   action="index.php" method="post">

            <input type="text" name="first_name" placeholder="First name" value="<?= $first_name ?>" required> <br>

            <input type="text" name="last_name" placeholder="Last name" value="<?= $last_name ?>" required> <br>

            <input type="email" name="email" placeholder="Email" value="<?= $email ?>" required> <br>

            <input type="password" name="password" placeholder="Password" required> <br>

            <input type="password" name="password_repeat" placeholder="Repeat password" required> <br>

            <p class="message">Gender: <select name="gender" required>

                <option value="m" <?= empty($gender) ? 'selected="selected"' : '' ?> >Male</option>

                <option value="f" <?= empty($gender) ? '' : ((($gender) == 'f') ? 'selected="selected"' : '') ?> >
                    Female
                </option>

            </select> </p><br>


            <input class="button" type="submit" name="register_button" value="Register">

            <p class="message">Already registered? <a href="index.php?page=login">Log in!</a>
            </p>

        </form>

    </div>
</div>

