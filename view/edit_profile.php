    <form action="index.php" method="post">

            <input type="text" name="first_name" value="<?= $user_info["user_fname"]; ?>" > <br>
            <input type="text" name="last_name" value="<?= $user_info["user_lname"]; ?>"> <br>
            <select name="gender">
                <option value="m" selected=<?php ($user_info["user_gender"] == "m" )?"selected":""; ?> >Male</option>
                <option value="f" selected=<?php ($user_info["user_gender"] == "f" )?"selected":""; ?> >Female</option>
            </select>
            <br>
            <input type="email" name="email" value="<?= $logged_email ;?>" placeholder="email"> <br>
            <input type="password" name="password_old" placeholder="old password"> <br>
            <input type="password" name="password_new" placeholder="new password"> <br>

            <input type="submit" name="save_profile_button" value="Save changes">
    </form>
