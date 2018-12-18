<?php
require_once 'db_connect.php';
require_once 'film.php';
require_once 'users.php';
    function startSession() {
        $session_name = 'FilmIO'; // Set a custom session name
        $secure = false; // Set to true if using https.
        $httponly = true; // This stops javascript being able to access the session id.
        
        ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies.
        $cookieParams = session_get_cookie_params(); // Gets current cookies params.
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
        session_name($session_name); // Sets the session name to the one set above.
        session_start(); // Start the php session
        session_regenerate_id(true); // regenerated the session, delete the old one.
    }
    
    function loginCheck() {
        global $client;
        // Check if all session variables are set
        if(isset($_SESSION['username'], $_SESSION['login_string'])) {
            $login_string = $_SESSION['login_string'];
            $username = $_SESSION['username'];
            $ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user.
            $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
            
            $result = $client->run("MATCH(n:User) WHERE n.username ='". $username ."' RETURN n");
            $record = $result->firstRecord();
            $node = $record->nodeValue("n");
            $password = $node->value("password");
                    $login_check = hash('sha512', $password.$ip_address.$user_browser);
                    if($login_check == $login_string) {
                        // Logged In!!!!
                        return true;
                    } else {
                        // Not logged in
                        //return false;
                        echo 'login check didnt return';
                    }
                } else {
                    
                    // Not logged in
                    //return false;
                    echo 'vars arent set';
                }
            
    }
    
    function checkRelationExists($username, $subject, $subjectType, $linkType){
        global $client;
        $number = -1;
        if($linkType == "friends" || $linkType == "likes" || $linkType == "dislikes" || $linkType == "friendreq"){
            if(strtolower($subjectType) == "film"){
                $result = $client->run('MATCH(u:User)-[r:'. $linkType . ']->(f:Film) WHERE u.username ="' . $username . '" AND f.ID="' . $subject . '"RETURN COUNT(r) as no');
                $number = $result->firstRecord()->value('no');
                
                
            }else if(strtolower($subjectType) == "user"){
                $result = $client->run('MATCH(u:User)-[r:'. $linkType . ']->(u1:User) WHERE u.username ="' . $username . '" AND u1.username="' . $subject . '"RETURN COUNT(r) as no');
                $number = $result->firstRecord()->value('no');
            }
            
            if($number > 0){
                return true;
            }else{
                return false;
            }
            
        }
        
        
        
    }
    
    function createFilmUserLink($username, $filmID, $linkType){
        global $client;
        if($linkType == "pos"){
            if(!checkRelationExists($username, $filmID, "film", "likes")){
                $client->run('MATCH(u:User),(f:Film) WHERE u.username="' . $username .'" AND f.ID="'. $filmID .'" CREATE (u)-[r:likes]->(f)');
            }
            
            
            
        }else if($linkType == "neg"){
            if(!checkRelationExists($username, $filmID, "film", "dislikes")){
                $client->run('MATCH(u:User),(f:Film) WHERE u.username="' . $username .'" AND f.ID="'. $filmID .'" CREATE (u)-[r:dislikes]->(f)');
            }
        }
        else{
            echo 'invalid Link Type';
        }
    }
    function createUserUserLink($username1, $username2, $linkType){
        //TODO
    }
    
       function getFilmsUserLikes($username){
        global $client;
        $filmsLiked = array();
        $result = $client->run('MATCH(u:User), (f:Film) WHERE (u)-[:likes]->(f) AND u.username="'. $username .'" RETURN f, f.ID as ID, COUNT(f) as no');
        foreach ($result->records() as $record){
            $filmsLiked[] = new Film($record->value("ID"));
        }
        return $filmsLiked;
    }
    function getFilmsUserDislikes($username){
        global $client;
        $filmsDisliked = array();
        $result = $client->run('MATCH(u:User), (f:Film) WHERE (u)-[:dislikes]->(f) AND u.username="'. $username .'" RETURN f, f.ID as ID, COUNT(f) as no');
        foreach ($result->records() as $record){
            $filmsDisliked[] = new Film($record->value("ID"));
        }
        return $filmsDisliked;
    }
    
    function getUsersFriends($username){
        global $client;
        $friends = array();
        $result = $client->run('MATCH(u:User), (u1:User) WHERE (u)-[:friends]-(u1) AND u.username="' . $username . '" RETURN u1, u1.username as Username, COUNT(u1) as no');
        foreach ($result->records() as $record){
            $friends[] = $record->value("Username");
        }
        return $friends;
    }
    
    
    function getRecommendations($username){
        $recFilms = array();
        global $client;
        //TODO
        //METHOD
        //1. Get all films user has liked.
        //2. Check if any of the user's friends like that film
        //IF has friends
        //3. Recommend a film that the friend likes
        //ELSE
        //4. Recommend a top film
        //6. RETURN 5 films
        
        //1.
        $filmsLiked = getFilmsUserLikes($username);
        $filmsDisliked = getFilmsUserDislikes($username);
        //2.
        $friends = getUsersFriends($username);
        if(count($friends) > 0 && count($filmsLiked) > 0){
            
            foreach($friends as $friend){ //For every friend
                $friendsLikedFilms = getFilmsUserLikes($friend); //Get the films they like
                foreach($filmsLiked as $film){ //For each of the films found
                    
                    if(in_array($film, $friendsLikedFilms)){ //Check if any friends liked that film
                        //3.
                        foreach ($friendsLikedFilms as $friendFilm){ //For each film the friend liked
                            if(!in_array($friendFilm, $filmsDisliked) && !in_array($friendFilm, $filmsLiked)){ // make sure i haven't seen it
                                $recFilms[] = $friendFilm;
                            }
                            
                        }
                        
                    }
                }
            }
            
            //4.
            //             if(count($recFilms) < 5){
            
            //             }
            
            
            //             $freqs = array_count_values($recFilms);
            //             $recFilmsFreq = array();
            //             foreach($recFilms as $film){
            //                 $recFilmsFreq = [
            //                     $film => $freqs[$film]
            
            
            //                 ];
            //             }
            
            return $recFilms;
            
            
            
        }
        
        
        //Get all users that like that film
        //Recommend film that them users like
        //RETURN 5 films
        
        //6.
        return $recFilms;
    }






?>