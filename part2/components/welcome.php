<?php
session_start();
?>
<?php if (!isset($_SESSION['part2_username'])) { ?>
    <h1>
        Welcome to iStudy!
    </h1>
    <img src="../../shared/images/part2/istudy-logo.png" alt="istudy-logo">
    <p>
        <a class="login-trigger" href="#"> Login</a> To Get Started. <br>
        Don't have an account? <a class="signup-trigger" href="#">Create Account</a>
    </p>
<?php } else { ?>
    <h1>
        Welcome <?php echo $_SESSION['part2_username']; ?>
    </h1>
    <img src="../../shared/images/part2/istudy-logo.png" alt="istudy-logo">

<?php } ?>

<h3> Available Courses </h3>
<table class="centered">
    <thead>
        <tr>
            <th>Unit Id</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody id="availableCourses">

    </tbody>
</table>