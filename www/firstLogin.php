
<?php
require_once( $_SERVER['DOCUMENT_ROOT']. "./includes/functions.php");
startSession();
if(loginCheck()== true){
    
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
<nav class="navbar fixed-top navbar-expand-md navbar-dark bg-dark"> <!--<Navbar>-->

<div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2"><!-- Left --> 
	<ul class="navbar-nav mr-auto">
		<li class="nav-item">
			<a class="nav-link" href="#"><span class="fas fa-film"></span> Your Films</a>
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
	<a class="navbar-brand mx-auto" href="localhost">
		FilmIO
	  </a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
			<span class="navbar-toggler-icon"></span>
		</button>

</div>
<div class="navbar-collapse collapse w-100 order-3 dual-collapse2"> <!-- Right -->

	<ul class="navbar-nav ml-auto">
		<form class="form-inline my-2 my-lg-0">
		  <input class="form-control mr-sm-2" type="search" placeholder="Find a new film..." aria-label="Search">
		  <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
		</form>

	  <li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		  <?php echo $_SESSION['fullName'];?>
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown">
		  <a class="dropdown-item" href="#">Change Password</a>
		  <a class="dropdown-item" href="#">Notifications</a>
		  <div class="dropdown-divider"></div>
		  <a class="dropdown-item" href="/logout.php">Log Out</a>
		</div>
	  </li>




	</ul>
</div></nav> <!-- Navbar -->


<div class="row">
	<div class="col-12">
		<div class="jumbotron jumbotron-fluid">
		  <div class="container">
			<h1 class="display-4">Hello, <?php echo ucfirst($_SESSION['username']);?>!</h1>
			<p class="lead">Welcome to FilmIO! To help us get started please tell what you think of these films below:</p>
		  </div>
		</div>
	</div>
	
	<?php 
	
	$cards = array(new Film("0126029"), new Film("0377092"), new Film("0137523"));
	$thisCard = 0;
	foreach ($cards as $card){
	    echo'
        	<div class="col-4">
        		<div class="card">
                  	<img class="card-img-top" src="' . $card->getImgPath() . '" alt="Card image cap">
                  <div class="card-body">
                    <h5 class="card-title">' . $card->getName() . '</h5>
                    <p class="card-text">'. $card->getDescription() . '</p>
                    <div class="btn-group btn-group-lg" role="group">
                    <button href="#" id="button' . $thisCard . '1" onClick="ratingClick(this, \'' . $cards[$thisCard]->getFilmID() .'\', \'1\')" class="btn btn-success"><span class="fas fa-thumbs-up"></span></button>
                    <a href="#" class="btn btn-danger button' . $thisCard . '-1" onClick="ratingClick(this, \'' . $cards[$thisCard]->getFilmID() .'\', \'-1\')"><span class="fas fa-thumbs-down"></span></a>
                    <a href="#" class="btn btn-primary">I haven\'t seen it</a>
<div id="nowhere"></div>
                    </div>
                  </div>
                </div>
        	</div>
        ';
	    $thisCard++;
	}
	
	?>
	
</div>
	
	
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap-4.0.0.js"></script>
<script src="js/ratingClick.js"></script>


</body>
</html>
<?php }else{
    header("Location: /login.php");
}?>