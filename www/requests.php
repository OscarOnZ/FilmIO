<?php
/**
 * Copyright (c) Oscar Cameron 2019.
 */

/**
 * Created by PhpStorm.
 * User: oacam
 * Date: 22/01/2019
 * Time: 13:35
 */
require_once( $_SERVER['DOCUMENT_ROOT']. "./includes/functions.php");
startSession();
if(loginCheck()== true){
        if(count($_SESSION['thisUser']->getLikes()) > 3){
            header("Location: index.php");
        }
    ?>
<!doctype html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FilmIO</title>
<link href="../css/bootstrap-4.0.0.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
</head>

<body>
<div class="container-fluid" style="padding-top: 70px">
    <?php include_once("includes/navbar.php") ?>

</div>



<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap-4.0.0.js"></script>
<script src="js/searchBar.js"></script>
<script src="js/friendReqClick.js"></script>
</body>

    <footer>
        <hr>
        <p class="text-center text-secondary">FilmIO by Oscar Cameron Copyright &copy; 2018</p>
        <hr>
    </footer>
    </html>


    <?php
}else{
    header("Location: login.php");

} ?>