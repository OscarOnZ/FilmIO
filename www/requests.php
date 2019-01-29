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
if(!loginCheck()){
    header("Location: login.php");
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
    <?php include_once("includes/navbar.php"); ?>


    <div class="row">
        <div class="col-2">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="v-pills-r-tab" data-toggle="pill" href="#v-pills-r" role="tab" aria-controls="v-pills-received" aria-selected="true">Received</a>
                <a class="nav-link" id="v-pills-s-tab" data-toggle="pill" href="#v-pills-s" role="tab" aria-controls="v-pills-sent" aria-selected="false">Sent</a>
                <a class="nav-link" id="v-pills-e-tab" data-toggle="pill" href="#v-pills-e" role="tab" aria-controls="v-pills-existing" aria-selected="false">My Friends</a>
            </div>
        </div>
        <div class="col-10">
            <!--Received Friend Requests-->

            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-r" role="tabpanel" aria-labelledby="v-pills-r-tab">

                    <?php


                    $users = $_SESSION['thisUser']->getFriendRequests();
                    if(count($users) == 0){
                        echo "You haven't received any friend requests.";
                    }else{
                    foreach($users as $user){
                        ?>
                        <br>
                        <div class="card" style="width: 18rem;">
                            <img src="img/user-placeholder.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $user->getUsername(); ?></h5>
                                <p class="card-text">
                                <div class="btn-group" role="group" aria-label="sentButtons">
                                    <a role="button" class="btn btn-primary" href="viewUser.php?username=<?php echo $user->getUsername(); ?>">View Profile</a>
                                    <a href="/includes/createRelation.php?type=acceptFR&username=<?php echo $user->getUsername(); ?>" class="btn btn-primary">
                                        Accept</a>
                                    <a href="/includes/createRelation.php?type=denyFR&username=<?php echo $user->getUsername(); ?>" class="btn btn-primary">
                                        Deny</a>

                                </div>
                                </p>
                            </div>

                        </div>
                    <?php }}
                    ?>



                </div>

                <!--Sent Friend Requests-->
                <div class="tab-pane fade" id="v-pills-s" role="tabpanel" aria-labelledby="v-pills-s-tab">

                    <?php


                    $users = $_SESSION['thisUser']->getSentFriendRequests();
                    if(count($users) == 0){
                        echo "You haven't sent any friend requests.";
                    }else{
                    foreach($users as $user){
                        ?>
                        <br>
                        <div class="card" style="width: 18rem;">
                            <img src="img/user-placeholder.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $user->getUsername(); ?></h5>
                                <p class="card-text">
                                <div class="btn-group" role="group" aria-label="sentButtons">
                                    <a role="button" class="btn btn-primary" href="viewUser.php?username=<?php echo $user->getUsername(); ?>">View Profile</a>
                                    <a href="/includes/createRelation.php?type=withdrawFR&username=<?php echo $user->getUsername(); ?>" class="btn btn-primary">
                                        Withdraw</a>

                                </div>
                                </p>
                            </div>

                        </div>
                    <?php }}
                    ?>
                </div>


                <div class="tab-pane fade" id="v-pills-e" role="tabpanel" aria-labelledby="v-pills-e-tab">
            <!--                    Existing Friends-->
                    <?php


                    $users = $_SESSION['thisUser']->getFriends();
                    if(count($users) == 0){
                        echo "You haven't added any friends!";
                    }else{
                        foreach($users as $user){
                            ?>
                            <br>
                            <div class="card" style="width: 18rem;">
                                <img src="img/user-placeholder.png" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $user->getUsername(); ?></h5>
                                    <p class="card-text">
                                    <div class="btn-group" role="group" aria-label="sentButtons">
                                        <a role="button" class="btn btn-primary" href="viewUser.php?username=<?php echo $user->getUsername(); ?>">View Profile</a>
                                        <a href="/includes/createRelation.php?type=unfriend&username=<?php echo $user->getUsername(); ?>" class="btn btn-danger">
                                            Unfriend</a>

                                    </div>
                                    </p>
                                </div>

                            </div>
                        <?php }}
                    ?>
                </div>


            </div>
            </div>
        </div>
    </div>





</div>







<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap-4.0.0.js"></script>
<script src="js/ratingClick.js"></script>
<script src="js/searchBar.js"></script>
</body>

    <footer>
        <hr>
        <p class="text-center text-secondary">FilmIO by Oscar Cameron Copyright &copy; 2018</p>
        <hr>
    </footer>