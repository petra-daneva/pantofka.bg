<div id="register-form">
    <h3 class="error">Email taken already</h3>

    <form action="index.php" method="post" class="bottom-30">
        <input type="text" name="first_name" placeholder="first name"> <br>
        <input type="text" name="last_name" placeholder="last name"> <br>
        <select name="gender">
            <option value="m">Male</option>
            <option value="f">Female</option>
        </select>
        <br>
        <input type="email" name="email" placeholder="Email"> <br>
        <input type="password" name="password" placeholder="Password"> <br>
        <input type="password" name="password_repeat" placeholder="Repeat password"> <br>
        <input type="submit" name="login_button" value="Log in">
    </form>
    <a href="index.php?page=login">In case you already have a profile!</a>
</div>
