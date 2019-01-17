<?php
require_once 'db_connect.php';
require_once 'film.php';
require_once 'users.php';
    function startSession() {
        $session_name = 'FilmIO';
        $secure = false;
        $httponly = true;
        
        ini_set('session.use_only_cookies', 1); //Only use cookies
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
        session_name($session_name);
        session_start();
        session_regenerate_id(true);
    }
    
    function loginCheck() {
        global $client;
        // Check if all session variables are set
        if(isset($_SESSION['thisUser'], $_SESSION['login_string'])) {
            $login_string = $_SESSION['login_string'];
            $username = $_SESSION['thisUser']->getUsername();
            $ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user.
            $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
            
            $result = $client->run("MATCH(n:User) WHERE n.username ='". $username ."' RETURN n");
            $record = $result->firstRecord();
            $node = $record->nodeValue("n");
            $password = $node->value("password");
                    $login_check = hash('sha512', $password.$ip_address.$user_browser);
                    if($login_check == $login_string) {
                        // Logged In
                        return true;
                    } else {
                        // Not logged in
                        return false;
                        //echo 'login check didnt return';
                    }
                } else {
                    
                    // Not logged in
                    return false;
                }
            
    }

/**
 * @param int $nFilms
 * @return Film[]
 */
function getGlobalFilmList($nFilms){


        global $client;
        $topFilms = [];
        $result = $client->run("  START n=node(*)
                                        MATCH ()-[r:likes]->(n:Film)
                                        RETURN n.ID as FilmID, count(r) as nRels
                                        ORDER BY nRels DESC LIMIT " . $nFilms);
        foreach($result->records() as $record){
            $topFilms[] = array(new Film($record->value("FilmID")), "score" => $record->value("nRels"));
        }

        return $topFilms;

    }






