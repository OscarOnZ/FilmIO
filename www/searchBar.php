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

    }else{
        header("location: index.php");
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
        <?php include_once ("includes/navbar.php"); ?>
    </div>
    <div class="container">
        <?php

        if(isset($_GET['success'])){
            ?>
            <div class="alert alert-success text-center" role="alert">
                Thanks for adding a film!
            </div>

        <?php
        }
        else if(isset($_GET['error'])){
            if($_GET['error'] == "invalidURL"){
                ?>
                <div class="alert alert-warning text-center" role="alert">
                    That url didn't seem correct. Please double check and try again.
                </div>

        <?php
            }
            else if($_GET['error'] == "exists"){ ?>
                <div class="alert alert-info text-center" role="alert">
                    We already have that film in our database!
                </div>
            <?php
            }
        }


        ?>
        <p class="text-sm-right"> We found <?php echo(count($films) + count($users)); ?> result(s)</p>

        <?php
        if(count($films) > 0){
            echo'<h3 class="text-center">Films</h3>';

        foreach ($films as $film) {
            $thisFilm = new Film($film);
            echo'
        <div class="card">
            <h5 class="card-header">' . $thisFilm->getName()  . ' (' . $thisFilm->getYear() . ')</h5>
            <div class="card-body">
                <p class="card-text">' . $thisFilm->getDescription() . '</p>
                <a href="viewFilm.php?id=' . $thisFilm->getFilmID() . '" class="btn btn-primary">View This Film</a>
            </div>
        </div>
        <hr>';}


        } ?>

        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#cantFindModal">
            Can't find the film you're looking for?
        </button>



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
                    <a href="viewUser.php?username=' . $user->getUsername() . '" class="btn btn-primary">View Profile</a>
                    <a href="#" class="btn btn-primary" onClick="friendReqClick(this, \'' . $user->getUsername() .'\')">
                    Send Friend Request</a>
                </div>
            </div>
        </div>
        <hr>';

            }} ?>


    </div>

    <!--Can't find Modal -->
    <div class="modal fade" id="cantFindModal" tabindex="-1" role="dialog" aria-labelledby="cantFindModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cantFindModalLabel">Submit film request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Can't find the film you're looking for? Please search for the film on <a href="https://imdb.com" target="_blank">IMDB</a> and enter the url below:</p>

                    <form class="form" method="post" action="includes/addFilm2.php">
                        <div class="form-group">
                            <label for="url">IMDB URL</label>
                            <input type=url class="form-control" id="url" name="url" aria-describedby="urlHelp" placeholder="Enter full URL">
                            <small id="urlHelp" class="form-text text-muted">Enter full url, e.g. https://www.imdb.com/title/tt0111161/?pf_rd_m=....</small>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>



    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.0.0.js"></script>
    <script src="js/friendReqClick.js"></script>




    </body>
    </html>


<?php } ?>
