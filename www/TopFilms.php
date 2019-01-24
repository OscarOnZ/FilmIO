<?php
/**
 * Copyright (c) Oscar Cameron 2019.
 */

/**
 * Created by PhpStorm.
 * User: oacam
 * Date: 17/01/2019
 * Time: 13:16
 */

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
<link href="css/bootstrap-4.0.0.css" rel="stylesheet" type="text/css">
<link href="css/custom.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
</head>

<body>
<div class="container-fluid" style="padding-top: 70px">
    <?php include_once ("includes/navbar.php"); ?>
	<div class="row">
		<div class="col-12">
			<div class="jumbotron jumbotron-fluid">
			  <div class="container">
				<h1 class="display-4">All-Time Top Films</h1>
				<p class="lead">Here are the films our users like the most</p>
			  </div>
			</div>
		</div>
	</div>
<!--    Recommendation Cards-->

	<?php
    $nFilms = 10;
	$cards = getGlobalFilmList($nFilms);
	    for($i = 1; $i < $nFilms; $i++){

	            echo'
        	
                    <div class="card">
                      <div class="row">
                        <div class="col-md-4">
                            <img src="' . $cards[$i - 1][0]->getImgPath() .'" style="max-width: 200px">
                          </div>
                          <div class="col-md-8 px-3">
                            <div class="card-block px-3">
                              <h4 class="card-title">Rank #' . $i .': ' . $cards[$i - 1][0]->getName() .'</h4>
                              <p class="card-text"> ' . $cards[$i - 1][0]->getDescription() . '</p>
                              <p class="card-text">This film is liked by ' . $cards[$i - 1]['score'] .' users</p>
                              <a href="viewFilm.php?id=' . $cards[$i -1][0]->getFilmID() .'" class="btn btn-primary">Go to this film</a>
                            </div>
                          </div>
                
                        </div>
                      </div>
                      <hr>

        ';

	    }


	?>
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
