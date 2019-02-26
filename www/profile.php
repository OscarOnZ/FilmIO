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
    $user = $_SESSION['thisUser'];

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

    <div class="container-fluid">

        <?php if(isset($_GET['error']) && $_GET['error'] == "noPW"){
            ?>

            <div class="alert alert-warning" role="alert">
                Please complete the new password field.
            </div>

        <?php } ?>


        <div class="row">
            <div class="col-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-p-tab" data-toggle="pill" href="#v-pills-p" role="tab" aria-controls="v-pills-profile" aria-selected="true">Public Profile</a>
                    <a class="nav-link" id="v-pills-i-tab" data-toggle="pill" href="#v-pills-i" role="tab" aria-controls="v-pills-info" aria-selected="false">Edit User Info</a>
                    <br>
                    <a class="nav-link btn btn-outline-danger" href="logout.php">Logout</a>
                </div>
            </div>

            <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-p" role="tabpanel" aria-labelledby="v-pills-p-tab">
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
                                        if(count($user->getLikes()) == 0){
                                            $filmsLiked = "nothing apparently!";
                                        }else{
                                            foreach($user->getLikes() as $film){
                                                $filmsLiked = $filmsLiked . $film->getName() . ", ";
                                            }
                                        }


                                        ?>
                                        <p class="card-text"><?php echo $user->getFullName() . " likes " . $filmsLiked;?></p>
                                    </div>
                                </div>

                                <div style="padding: 15px"></div>
                                <div class="card">
                                    <div class="card-header">
                                        Do you know <?php echo $user->getFirstName() ?>?
                                    </div>
                                    <div class="card-body text-center">
                                        <button href="" class="btn btn-primary disabled" onClick="#" title="You can't friend yourself!">
                                            Send Friend Request</button>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade show" id="v-pills-i" role="tabpanel" aria-labelledby="v-pills-i-tab">
                        <br>
                        <div class="row">
                            <div class="col-3"></div>
                            <div class="col-6">
                                <form method="post" action="includes/doChangePW.php">
                                    <div class="form-group row">
                                        <label for="staticName" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $_SESSION['thisUser']->getFullName(); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $_SESSION['thisUser']->getEmail(); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="newPW" name="newPW" placeholder="Enter a new password">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" id="submit">Change Password</button>
                                </form>
                            </div>

                        </div>



                    </div>
                </div>




            </div>


        </div>
    </div>




    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.0.0.js"></script>
    <script src="js/searchBar.js"></script>
    <script src="js/friendReqClick.js"></script>
    <script src="js/doChangePW.js"></script>
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