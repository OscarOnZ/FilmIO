<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
startSession();
if(loginCheck()) {
    if(isset($_GET['id'])){
        try{
            $film = new Film($_GET['id']);
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
    <link href="../css/bootstrap-4.0.0.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
</head>

<body>
<div class="container-fluid" style="padding-top: 70px">
    <?php include_once ("includes/navbar.php"); ?>

</div>
<div class="container">


    <div class="row">

        <div class="col-4">
            <img src="<?php echo $film->getImgPath() ?>" class="img-fluid img-thumbnail">
        </div>
        <div class="col-8">
            <h1 class="display-4 text-center"><?php echo $film->getName() ?></h1>
            <div class="text-center" style="padding-bottom: 15px">
             <p class="lead text-success"><?php
                 if($film->getTotalLikes() == 1){
                     echo ($film->getTotalLikes() . " user likes this film");
                 }else {
                     echo($film->getTotalLikes() . " users like this film");
                 }
                 ?></p>
            </div>
            <div class="card">
                <div class="card-header">
                    Description
                </div>
                <div class="card-body">
                    <p class="card-text"><?php echo $film->getDescription(); ?></p>
                </div>
            </div>
            <div style="padding: 15px"></div>
            <div class="card">
                <div class="card-header">
                    Have you seen this film?
                </div>
                <div class="card-body text-center">
                    <button type="button" class="btn btn-success" id="buttonLike" onclick="ratingClick(this, '<?php echo $_GET['id'] ?>', '1')"> I like this film</button>
                    <button type="button" class="btn btn-danger" id="buttonDislike" onclick="ratingClick(this, '<?php echo $_GET['id'] ?>', '-1')"> I dislike this film</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap-4.0.0.js"></script>
<script src="js/ratingClick.js"></script>

</body>

<footer>
    <hr>
    <p class="text-center text-secondary">FilmIO by Oscar Cameron Copyright &copy; 2018</p>
    <hr>

</footer>
</html>

<?php
}
else{
    header("Location: index.php");
}
?>
