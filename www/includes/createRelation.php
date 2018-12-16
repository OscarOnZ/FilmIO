<?php

require_once( $_SERVER['DOCUMENT_ROOT']. "./includes/functions.php");
startSession();
if(loginCheck()){
    
    if(isset($_GET['type'])){
        
        if($_GET['type'] == "userFilm"){
            if(isset($_GET['score']) && $_GET['score'] == 1 && isset($_GET['filmID'])){ // Positive Rating
                
                createFilmUserLink($_SESSION['username'], $_GET['filmID'], "pos");
                header("Location: {$_SERVER['HTTP_REFERER']}");
                
            }
            if(isset($_GET['score']) && $_GET['score'] == -1 && isset($_GET['filmID'])){ // Negative Rating
                
                createFilmUserLink($_SESSION['username'], $_GET['filmID'], "neg");
                header("Location: {$_SERVER['HTTP_REFERER']}");
            }
        }
        
    }
    
}
else{
    header("Location: ../index.php");
}

