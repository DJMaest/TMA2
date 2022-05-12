<?php
session_start()
?>
<?php if (!isset($_SESSION['part1_username'])) { ?>
    <h1>
        Welcome to BookMarks!
    </h1>
    <img src="../../shared/images/part1/bookmarks-logo.png" alt="istudy-logo">
    <p>
        <a class="login-trigger" href="#"> Login</a> To Get Started. <br>
        Don't have an account? <a class="signup-trigger" href="#">Create Account</a>
    </p>
<?php } else { ?>
    <h1>
        Welcome <?php echo $_SESSION['part1_username']; ?>
    </h1>
    <img src="../../shared/images/part1/bookmarks-logo.png" alt="istudy-logo">

<?php } ?>
<h3>
    Top 10 Websites
</h3>
<table class="centered">
    <thead>
        <tr>
            <th>Link</th>
            <th>URL</th>
            <th>Bookmarks</th>
        </tr>
    </thead>

    <tbody id="popularData">

    </tbody>
</table>