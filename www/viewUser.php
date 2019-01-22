<?php
/**
 * Copyright (c) Oscar Cameron 2019.
 */

/**
 * Created by PhpStorm.
 * User: oacam
 * Date: 10/01/2019
 * Time: 13:34
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
startSession();
if(loginCheck()) {
    if(isset($_GET['username'])){
        try{
            $user = new User($_GET['username']);
        }catch(Exception $e){
            header("Location: index.php");
        }
    }
    else{
        header("Location: index.php");
    }
    $me = false;
    if($user->getUsername() == $_SESSION['thisUser']->getUsername()){
        $me = true;
    }


    ?>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FilmIO</title>
<link href="css/bootstrap-4.0.0.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
</head>

<body>
<div class="container-fluid" style="padding-top: 70px">
    <?php include_once ("includes/navbar.php"); ?>


</div>

<div class="container">

    <?php if($me){ ?>

        <div class="alert alert-info"> This is how your profile looks to the public</div>


    <?php } ?>

    <div class="row">

        <div class="col-4">
            <img src="img/user-placeholder.png" class="img-fluid img-thumbnail">
        </div>
        <div class="col-8">
            <h1 class="display-4 text-center"><?php echo $user->getFullName() ?></h1>
            <div class="text-center" style="padding-bottom: 15px">
                <p class="lead text-success"><?php
                    if($user->getNumberOfFriends() == 1){
                        echo (ucfirst($user->getUsername()) . " has " . $user->getNumberOfFriends() . " friend");
                    }else {
                        echo(ucfirst($user->getUsername()) . " has " . $user->getNumberOfFriends() . " friends");
                    }
                    ?></p>
            </div>
            <div class="card">
                <div class="card-header">
                    Liked Films
                </div>
                <div class="card-body">
                    <?php

                    $filmsLiked = "";
                    foreach($user->getLikes() as $film){
                        $filmsLiked = $filmsLiked . $film->getName() . ", ";
                    }

                    ?>
                    <p class="card-text"><?php echo $user->getFullName() . " likes " . $filmsLiked;?></p>
                </div>
            </div>

            <div style="padding: 15px"></div>
            <?php if(!$me){ ?>
            <div class="card">
                <div class="card-header">
                    Do you know <?php echo $user->getFirstName() ?>?
                </div>
                <div class="card-body text-center">
                    <a href="" class="btn btn-primary" onClick="friendReqClick(this, <?php $user->getUsername() ?>)">
                        Send Friend Request</a>

                </div>
            </div>
        <?php } ?>
        </div>
    </div>
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