<?php

require_once( $_SERVER['DOCUMENT_ROOT']. "./includes/functions.php");
startSession();
if(loginCheck()){
    if(isset($_GET['type'])){
        $thisUser = $_SESSION['thisUser'];
        if($_GET['type'] == "userFilm"){



            $thisFilm = new Film($_GET['filmID']);


            if(isset($_GET['score']) && $_GET['score'] == '1' && isset($_GET['filmID'])){ // Positive Rating
                $thisUser->likes($thisFilm);

                
            }
            else if(isset($_GET['score']) && $_GET['score'] == '-1' && isset($_GET['filmID'])){ // Negative Rating

                $thisUser->dislikes($thisFilm);
            }
            else{
                //There's been a problem - send the user back to the index page so they can try again.
                header("Location: ../index.php");
            }
        }
        else if($_GET['type'] == "userUser"){
            $requestToUser = new User($_GET['username']);
            $thisUser->sendFriendRequest($requestToUser);
        }
        else if($_GET['type'] == "withdrawFR"){
            $requestUser = new User($_GET['username']);
            if($thisUser->withdrawFriendRequest($requestUser)){
                header("Location: ../requests.php?sent");
            }else{
                header("Location: ../requests.php?fail");
            }

        }
        else if($_GET['type'] == "acceptFR"){
            $requestUser = new User($_GET['username']);
            $thisUser->acceptFriendRequest($requestUser);
            header("Location: ../requests.php");
        }
        else if($_GET['type'] == "denyFR"){
            $requestUser = new User($_GET['username']);
            $thisUser->denyFriendRequest($requestUser);
            header("Location: ../requests.php");
        }
        else if($_GET['type'] == "unfriend"){
            $requestUser = new User($_GET['username']);
            $thisUser->unfriend($requestUser);
            header("Location: ../requests.php");
        }

        else{
            //There's been a problem - send the user back to the index page so they can try again.
            header("Location: ../index.php");
        }
        
    }else{
        //There's been a problem - send the user back to the index page so they can try again.
        header("Location: ../index.php");
    }
    
}
else{
    header("Location: ../login.php");
}

