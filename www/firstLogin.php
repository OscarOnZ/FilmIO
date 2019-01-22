
<?php
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


<div class="row">
	<div class="col-12">
		<div class="jumbotron jumbotron-fluid">
		  <div class="container">
			<h1 class="display-4">Hello, <?php echo $_SESSION['thisUser']->getFullName()?>!</h1>
			<p class="lead">Welcome to FilmIO! To help us get started please tell what you think of these films below:</p>
            <p class="lead">Please note, if you don't like any of these films, click the thumbs-down then search for the film above and tell us you like it!</p>
		  </div>
		</div>
	</div>
	
	<?php 
	//TODO
    // make $cards[] based on top films
    $nFilms = 4;
	$cards = getGlobalFilmList($nFilms);
    for($i = 1; $i < $nFilms; $i++){

        echo'
        	<div class="col-4">
        		<div class="card">
                  	<img class="card-img-top" src="' . $cards[$i - 1][0]->getImgPath() . '" alt="Card image cap">
                  <div class="card-body">
                    <h5 class="card-title">' . $cards[$i - 1][0]->getName() . '</h5>
                    <p class="card-text">'. $cards[$i - 1][0]->getDescription() . '</p>
                    <div class="btn-group btn-group-lg" role="group">
                        <button href="#" id="button' . $i . '1" onClick="ratingClick(this, \'' . $cards[$i - 1][0]->getFilmID() .'\', \'1\')" class="btn btn-success"><span class="fas fa-thumbs-up"></span></button>
                        <button href="#" class="btn btn-danger button' . $i . '-1" onClick="ratingClick(this, \'' . $cards[$i - 1][0]->getFilmID() .'\', \'-1\')"><span class="fas fa-thumbs-down"></span></button>
                        <button href="#" class="btn btn-primary">I haven\'t seen it</button>
                    </div>
                  </div>
                </div>
        	</div>

        ';

    }
	
	?>
	
</div>
	
	
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap-4.0.0.js"></script>
<script src="js/ratingClick.js"></script>
<script src="js/searchBar.js"></script>


</body>
</html>
<?php }else{
    header("Location: /login.php");
}?>