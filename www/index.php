<?php 
require_once( $_SERVER['DOCUMENT_ROOT']. "./includes/functions.php");
startSession();
if(loginCheck()== true){
    

?>
<html lang="en">
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
	<a class="navbar-brand mx-auto" href="#">
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
		  <a class="dropdown-item" href="#">My Profile</a>
		  <div class="dropdown-divider"></div>
		  <a class="dropdown-item" href="#">Settings</a>
		  <a class="dropdown-item" href="/logout.php">Log Out</a>
		</div>
	  </li>




	</ul>
</div>
</nav> <!-- </Navbar> -->

	
	<div class="row">
		<div class="col-12">
			<div class="jumbotron jumbotron-fluid">
			  <div class="container">
				<h1 class="display-4">Hello, <?php echo ucfirst($_SESSION['username']);?>!</h1>
				<p class="lead">Welcome back, here are your latest film recommendations</p>
			  </div>
			</div>
		</div>
	</div>
	
	<div class="row">
	<?php 
	
	$cards = getRecommendations($_SESSION['username']);
	$cardsCount = 0;
	try{
	    foreach($cards as $card) {
	        if($cardsCount < 4){
	            echo'
        	<div class="col-3">
        		<div class="card">
                  	<img class="card-img-top img-fluid" src="' . $card->getImgPath() . '" alt="Card image cap">
                  <div class="card-body">
                    <h5 class="card-title">' . $card->getName() . '</h5>
                    <p class="card-text">'. $card->getDescription() . '</p>
                    <a href="/viewFilm.php?id=' . $card->getFilmID() .'" class="btn btn-primary">Go to this film</a>
                  </div>
                </div>
        	</div>
        ';
	            $cardsCount++;
	        }
	        
	    }
	}catch(OutOfBoundsException $e){
	    
	    //TODO - Call to a getRecommendations with no username which returns a list of generic recommendations.
	    
	}
	
	
	?>
	</div>
	
	
	</div>
	

	
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap-4.0.0.js"></script>
</body>

    <footer>
        <hr>
        <p class="text-center text-secondary">FilmIO by Oscar Cameron Copyright &copy; 2018</p>
        <hr>

    </footer>
</html>
<?php }else{
    header("Location: /login.php");
}?>