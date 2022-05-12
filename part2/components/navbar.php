<?php
    session_start();
?>
<header>
    <nav class="navbar">
        <div class="logo">
            <a href="">iStudy</a>
        </div>
        <div>
            <ul class="">
                <?php if (isset($_SESSION['part2_username'])) { ?>
                    <li><a id="profile" href="">Profile</a></li>
                    <li><a id="mycourses" href="">My Courses</a></li>
                <?php } ?>

                <?php if (isset($_SESSION['part2_username'])) { ?>
                    <li><a id="logout" href="#">Logout</a></li>
                <?php } else { ?>
                    <li><a class="login-trigger" href="#">Login</a></li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</header>