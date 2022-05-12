<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.sandbox.google.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <!--Import materialize.css-->
    <link rel="stylesheet" href="../shared/css/main.css">
    <script src="../shared/js/jquery.js"></script>
    <title>iStudy</title>
</head>

<body>

    <div id="navbar">
        <?php require_once('./components/navbar.php') ?>
    </div>
    <div id="container" class="container center">
        <?php require_once('./components/welcome.php') ?>
    </div>
    <?php require_once('./components/signInModal.php') ?>
    <?php require_once('./components/signUpModal.php') ?>
    <div class="footer">
        <p>To navigate to the project file (tma2.htm) <a href="../tma2.htm">click here</a>.</p>
        &copy; Alireza Azimi 2022
    </div>
    <div id="snackbar">Some text some message...</div>
    <script src="main.js"></script>
</body>


</html>