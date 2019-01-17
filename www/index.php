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
<?php include_once("includes/navbar.php") ?>

	
	<div class="row">
		<div class="col-12">
			<div class="jumbotron jumbotron-fluid">
			  <div class="container">
				<h1 class="display-4">Hello, <?php echo ucfirst($_SESSION['thisUser']->getFirstName());?>!</h1>
				<p class="lead">Welcome back, here are your latest film recommendations</p>
			  </div>
			</div>
		</div>
	</div>
<!--    Recommendation Cards-->
	<div class="row">
	<?php 
	
	$cards = $_SESSION['thisUser']->newGetRecommendations();
	$cardsCount = 0;
	try{
	    foreach($cards as $card) {
	        if($cardsCount < 4){
	            echo'
        	<div class="col">
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
<!--	/Recommendation Cards-->



	</div>
	

	
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
<?php }else{
    header("Location: /login.php");
}?>