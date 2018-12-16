<?php 
require_once( $_SERVER['DOCUMENT_ROOT']. "./includes/functions.php");
startSession();
if(loginCheck()== true){
    

?>
<!doctype html>
<html>
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
	
	
<!doctype html>	
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
		  <a class="dropdown-item" href="#">Change Password</a>
		  <a class="dropdown-item" href="#">Notifications</a>
		  <div class="dropdown-divider"></div>
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
		<div class="col">
			<div class="card" style="">
			  <img class="card-img-top" src="https://m.media-amazon.com/images/M/MV5BMjJmYTNkNmItYjYyZC00MGUxLWJhNWMtZDY4Nzc1MDAwMzU5XkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_SY1000_CR0,0,676,1000_AL_.jpg" alt="Card image cap">
			  <div class="card-body">
				<h5 class="card-title">Fight Club</h5>
				<p class="card-text">This is some short and snappy text about the film, describing its plot and basic infomation. This will be populated automatically</p>
				<a href="#" class="btn btn-primary">Go to this film</a>
			  </div>
			</div>
		</div>
		<div class="col">
			<div class="card" style="">
			  <img class="card-img-top" src="https://m.media-amazon.com/images/M/MV5BMjAxMzY3NjcxNF5BMl5BanBnXkFtZTcwNTI5OTM0Mw@@._V1_SY1000_CR0,0,675,1000_AL_.jpg" alt="Card image cap">
			  <div class="card-body">
				<h5 class="card-title">Inception</h5>
				<p class="card-text">This is some short and snappy text about the film, describing its plot and basic infomation. This will be populated automatically</p>
				<a href="#" class="btn btn-primary">Go to this film</a>
			  </div>
			</div>
		</div>
		<div class="col">
			<div class="card" style="">
			  <img class="card-img-top" src="https://m.media-amazon.com/images/M/MV5BMDdmZGU3NDQtY2E5My00ZTliLWIzOTUtMTY4ZGI1YjdiNjk3XkEyXkFqcGdeQXVyNTA4NzY1MzY@._V1_SY1000_CR0,0,671,1000_AL_.jpg" alt="Card image cap">
			  <div class="card-body">
				<h5 class="card-title">Titanic</h5>
				<p class="card-text">This is some short and snappy text about the film, describing its plot and basic infomation. This will be populated automatically</p>
				<a href="#" class="btn btn-primary">Go to this film</a>
			  </div>
			</div>
		</div>
		<div class="col">
			<div class="card" style="">
			  <img class="card-img-top" src="https://m.media-amazon.com/images/M/MV5BZjdkOTU3MDktN2IxOS00OGEyLWFmMjktY2FiMmZkNWIyODZiXkEyXkFqcGdeQXVyMTMxODk2OTU@._V1_SY1000_SX675_AL_.jpg" alt="Card image cap">
			  <div class="card-body">
				<h5 class="card-title">Interstellar</h5>
				<p class="card-text">This is some short and snappy text about the film, describing its plot and basic infomation. This will be populated automatically</p>
				<a href="#" class="btn btn-primary">Go to this film</a>
			  </div>
			</div>
		</div>
	</div>
	
	
	</div>
	

	
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap-4.0.0.js"></script>
</body>
</html>
<?php }else{
    header("Location: /login.php");
}?>