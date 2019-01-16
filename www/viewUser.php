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
<nav class="navbar fixed-top navbar-expand-md navbar-dark bg-dark"> <!--<Navbar>-->

<div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2"><!-- Left -->
	<ul class="navbar-nav mr-auto">
		<li class="nav-item">
			<a class="nav-link" href="index.php"><span class="fas fa-film"></span> Your Films</a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="#"><span class="fas fa-newspaper"></span> News Feed</a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="#"><span class="fas fa-pencil-alt"></span> New Review</a>
		</li>
	</ul>
</div>
<div class="mx-auto order-0"> <!-- Middle -->
	<a class="navbar-brand mx-auto" href="index.php">
		FilmIO
	  </a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
			<span class="navbar-toggler-icon"></span>
		</button>

</div>
<div class="navbar-collapse collapse w-100 order-3 dual-collapse2"> <!-- Right -->

	<ul class="navbar-nav ml-auto">
		<form class="form-inline my-2 my-lg-0" action="searchBar.php" method="GET">
		  <input class="form-control mr-sm-2" type="search" name="text" placeholder="Find a new film..." aria-label="Search"">
		  <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
		</form>

	  <li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		  <?php echo $_SESSION['thisUser']->getFullName();?>
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown">
		  <a class="dropdown-item" href="#">My Profile</a>
		  <div class="dropdown-divider"></div>
		  <a class="dropdown-item" href="#">Settings</a>
		  <a class="dropdown-item" href="/logout.php">Log Out</a>
		</div>
	  </li>




	</ul>
</div>
</nav> <!-- </Navbar> -->


</div>

<div class="container">


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
                    Description
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
            <div class="card">
                <div class="card-header">
                    Do you know <?php echo $user->getFirstName() ?>?
                </div>
                <div class="card-body text-center">
                    <button type="button" class="btn btn-success" id="buttonLike" onclick="ratingClick(this, '<?php echo $_GET['id'] ?>', '1')"> I like this film</button>
                    <button type="button" class="btn btn-danger" id="buttonDislike" onclick="ratingClick(this, '<?php echo $_GET['id'] ?>', '-1')"> I dislike this film</button>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $_SESSION['thisUser']->newGetRecommendations(); ?>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap-4.0.0.js"></script>
<script src="js/searchBar.js"></script>
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