<?php
require_once 'functions.php';
global $client;

if(isset($_POST['url'])){
    if(preg_match("@https:\/\/www\.imdb\.com\/title\/tt[0-9]{7}@", $_POST['url'])){ //Check the string given
                                                                                    // looks like an IMDB URL
        $filmID = substr($_POST['url'], 29, 7);

        $thisFilm = new Film($filmID);
        if ($thisFilm->getFilmID() != null){ //If returned null, then the ID must be invalid. Else, the film exists.
            if($thisFilm->existsInDB()){
                //Found the film in the local DB already; show the user that it exists and tell them it already exists
                header("location: ../searchBar.php?text=" . urlencode($thisFilm->getName()) . "&error=exists");
            }
            else{
                //Film doesn't exist, so add it to the database.

                $client->run('CREATE (f:Film{ID:"' . $thisFilm->getFilmID() . '", filmName:"'
                    . $thisFilm->getName() .'"})');

                //Reload the page to show the user it has now been added.
                header("Location: ../searchBar.php?text=" . urlencode($thisFilm->getName()) . "&success=1");

            }
        }else{

            //Not a valid IMDB ID, so not a valid URL.
            header("location: ../searchBar.php?text=+&error=invalidURL");
        }


    }else{
        //Not a valid URL
        header("location: ../searchBar.php?text=+&error=invalidURL");
    }

}else{
    //Invalid URL
    header("location: ../searchBar.php?text=+&error=invalidURL");
}


