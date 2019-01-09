<?php

require_once( $_SERVER['DOCUMENT_ROOT']. "./includes/functions.php");
startSession();
if(loginCheck()){
    if(isset($_GET['type'])){
        
        if($_GET['type'] == "userFilm"){


            $thisUser = $_SESSION['thisUser'];
            $thisFilm = new Film($_GET['filmID']);


            if(isset($_GET['score']) && $_GET['score'] == 1 && isset($_GET['filmID'])){ // Positive Rating
                $thisUser->likes($thisFilm);
                echo 'pos rating recorded ' . $_SESSION['username'] . ' ' . $_GET['filmID']; 
                
            }
            else if(isset($_GET['score']) && $_GET['score'] == -1 && isset($_GET['filmID'])){ // Negative Rating

                $thisUser->dislikes($thisFilm);
                echo 'neg rating recorded'; 
            }
            else{
                echo 'invalid score';
            }
        }
        else{
            echo 'userFilm not set';
        }
        
    }else{
        echo 'type not set';
    }
    
}
else{
    echo 'not logged in';
}

