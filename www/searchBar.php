<?php
/**
 * Copyright (c) Oscar Cameron 2019.
 */

require_once( $_SERVER['DOCUMENT_ROOT']. "./includes/functions.php");
startSession();
if(!loginCheck()){
    header("Location: /login.php");
}else{

    if (isset($_GET['text'])) {
        global $client;

        //Get Film Results
        $films = [];
        $result = $client->run("START n = node(*) WHERE lower(n.filmName) CONTAINS lower('" . $_GET['text'] . "') RETURN n, n.ID as filmID");
        $records = $result->records();
        foreach ($records as $record) {
            $films[] = $record->value("filmID");
        }

        //Get User Results
        $users = [];
        $result = $client->run("START n = node(*) WHERE lower(n.username) CONTAINS lower('" . $_GET['text'] . "') OR lower(n.FullName) CONTAINS lower('" . $_GET['text'] . "') RETURN DISTINCT n, n.username as Username");
        $records = $result->records();
        foreach($records as $record){

            $users[] = new User($record->value("Username"));

        }

    }
    ?>

    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FilmIO</title>
        <link href="css/bootstrap-4.0.0.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css"
              integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns"
              crossorigin="anonymous">
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
                    <form class="form-inline my-2 my-lg-0" action="searchBar.php" method="GET">
                        <input class="form-control mr-sm-2" type="search" name="text" placeholder="Find a new film..."
                               aria-label="Search"">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $_SESSION['thisUser']->getFullName(); ?>
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
        <p class="text-sm-right"> We found <?php echo(count($films) + count($users)); ?> result(s)</p>

        <?php
        if(count($films) > 0){
            echo'<h3 class="text-center">Films</h3>';
        }
        foreach ($films as $film) {
            $thisFilm = new Film($film);
            echo'
        <div class="card">
            <h5 class="card-header">' . $thisFilm->getName()  . '</h5>
            <div class="card-body">
                <p class="card-text">' . $thisFilm->getDescription() . '</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
        <hr>';

        } ?>



            <?php
            if(count($users) > 0){
                echo'<h3 class="text-center">Users</h3><div class="row">';


            foreach ($users as $user) {
                echo'
        <div class="col">
            <div class="card">
                <h5 class="card-header">' . $user->getFullName() .'</h5>
                <div class="card-body">
                    <p class="card-text"></p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <hr>';

            }} ?>


        </div>



    </div>



    </body>
    </html>


<?php } ?>
