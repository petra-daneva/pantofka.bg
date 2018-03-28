<?php if ($error || $email_exists): ?>

    <h1 class="error center"> <?= $error ?> </h1>
    <h1 class="error center"> <?= $email_exists ?> </h1>

<?php endif; ?>

<div id="register-form">

        <form action="index.php" method="post" class="bottom-30">

            <input type="text" name="first_name" placeholder="First name" value="<?= $first_name ?>" required> <br>

            <input type="text" name="last_name" placeholder="Last name" value="<?= $last_name ?>"  required> <br>


            <select name="gender" required>

                <option value="m" <?= empty($gender)?'selected="selected"':'' ?>  >Male</option>

                <option value="f" <?= empty($gender)?'':((($gender)=='f')?'selected="selected"':'') ?> >Female </option>

            </select> <br>

            <input type="email" name="email" placeholder="Email" value="<?= $email ?>" required> <br>

            <input type="password" name="password" placeholder="Password" required> <br>

            <input type="password" name="password_repeat" placeholder="Repeat password" required> <br>

            <input type="submit" name="register_button" value="Register">

        </form>

    <a href="index.php?page=login">In case you already have a profile!</a>

</div>

