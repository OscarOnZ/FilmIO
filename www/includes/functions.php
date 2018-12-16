<?php
require_once 'db_connect.php';
require_once 'film.php';
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
    function createFilmUserLink($username, $filmID, $linkType){
        global $client;
        if($linkType == "pos"){
            $client->run('MATCH(u:User),(f:Film) WHERE u.username="' . $username .'" AND f.ID="'. $filmID .'" CREATE (u)-[r:likes]->(f)');
            
            
        }else if($linkType == "neg"){
            $client->run('MATCH(u:User),(f:Film) WHERE u.username="' . $username .'" AND f.ID="'. $filmID .'" CREATE (u)-[r:dislikes]->(f)');
        }
        else{
            echo 'invalid Link Type';
        }
    }
    function createUserUserLink($username1, $username2, $linkType){
        //TODO
    }
    
    function getRecommendations($username){
        $films = array();
        //TODO
        //METHODOLOGY
        //Get all films user has liked.
        //Check if any of the user's friends like that film
        //IF has friends
            //Recommend a film that the friend likes
        //ELSE
            //Get all users that like that film
            //Recommend film that them users like
        //RETURN 5 films
        
        return $films;
    }






?>