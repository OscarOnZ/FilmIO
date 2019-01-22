<?php
require_once ('functions.php');
global $client;
startSession();
    echo $_POST['Luname']; echo $_POST['Lpass'];
    if(isset($_POST['Luname']) && isset($_POST['Lpass'])){
    
    $username = strtolower($_POST['Luname']);
    $password = $_POST['Lpass'];
    
    //Checks username doesn't contain any symbols for SQL Inj. prevention
    if(preg_match('[\W]', $username)){
        header("Location: ../login.php?error=11"); // Invalid username
    }
    $user = new user($username, $password);
    
    //Check Username exists in DB
    if(!$user->existsInDB($user))
    {
        header("Location: ". $_SERVER["DOCUMENT_ROOT"] . "/login.php");
    }else
    {
        //Get database copy of password
        $result = $client->run("MATCH(n:User) WHERE n.username ='". $username ."' RETURN n");
        $record = $result->firstRecord();
        $node = $record->nodeValue("n");
        $db_password = $node->value("password");
        $fullName = $node->value("fullName");
    }
    
    
    
    
    //Compares given password to database password
    
    
    if(password_verify($password, $db_password)){
        
        //Log User in
        
        
        // Set Session Vars
        $ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.

        /**
         * @param User $_SESSION['thisUser]
         */
        $_SESSION['thisUser'] = new User($username);
        $_SESSION['login_string'] = hash('sha512', $db_password.$ip_address.$user_browser);
        
        
        
        
        
        header("Location: ../index.php");
        
    }else{
        header("Location: ../login.php?error=inputInc"); //Incorrect password, sends user to login page.
    }
}else{
    echo 'vars not set';
}

    
    
    
    

