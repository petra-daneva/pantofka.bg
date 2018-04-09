<div class="form-page centered-section">
    <div class="form">

        <form class="login-form" action="index.php" method="post" >

            <input type="email" name="email" placeholder="Email" value="<?= $email ?>" required> <br>

            <input type="password" name="password" placeholder="Password" required> <br>

            <input class="button" type="submit" name="login_button" value="Log in">
            <p class="message">Not registered? <a href="index.php?page=register">Create an account</a></p>
        </form>


    </div>

</div>

