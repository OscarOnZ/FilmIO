<?php

require_once( $_SERVER['DOCUMENT_ROOT']. "./includes/functions.php");
startSession();
if(loginCheck()){
    if(isset($_GET['type'])){
        $thisUser = $_SESSION['thisUser'];
        if($_GET['type'] == "userFilm"){



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
        else if($_GET['type'] == "userUser"){
            $requestToUser = new User($_GET['username']);
            $thisUser->sendFriendRequest($requestToUser);
        }
        else{
            echo 'invalid type';
        }
        
    }else{
        echo 'type not set';
    }
    
}
else{
    echo 'not logged in';
}

