<div style="height:500px;" class="form-container">
    <form id="updateUsername" method="POST" action="api/user/updateuname.php">

        <span class="material-symbols-outlined">
            account_circle
        </span>
        <div class="input-field">
            <label for="username">Username</label>
            <input  style="width:300px" name="username" type="text" value="<?php
                                                                            session_start();

                                                                            echo $_SESSION["part1_username"];  ?>"><br>
        </div>
        <br>
        <input style="width:100px" type="submit" value="Update Username" class="btn">

    </form>

    <form style="margin-top:15px;" id="updatePassword" method="POST" action="api/user/updatepass.php">
        <span class="material-symbols-outlined">
            lock
        </span>
        <div class="input-field">
            <label for="pass">Old Password</label>
            <input name="oldPass" type="password" id="pass">
        </div>
        <div class="input-field">
            <label for="pass">New Password</label>
            <input name="newPass" type="password" id="passConfirm">
        </div>
        <br>
        <input type="submit" value="Update Password" class="btn">

    </form>
</div>