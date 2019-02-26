<?php

    require_once("functions.php");
    
    
    //get POST Variables
    if(isset($_POST['rusername'])){
        $username = strtolower($_POST['rusername']);
    }else{
        header('Location: '. '../login.php?error=blankField');
        }
    if(isset($_POST['rpassword'])){
        $pw = $_POST['rpassword'];
    }else{
        header('Location: '. '../login.php?error=blankField');
    }
    if(isset($_POST['remail'])){
        $email = strtolower($_POST['remail']);
    }else{
        header('Location: '. '../login.php?error=blankField');
    }
    if(isset($_POST['rdob'])){
        $dob = $_POST['rdob'];
    }else{
        header('Location: '. '../login.php?error=blankField');
    }
    if(isset($_POST['rfullName'])){
        $fullName = $_POST['rfullName'];
    }else{
        header('Location: '. '../login.php?error=blankField');
    }
    if(isset($_POST['rconfirm'])){
        $confirm = $_POST['rconfirm'];
    }else{
        header('Location: '. '../login.php?error=blankField');
    }
    
    if($pw == $confirm){
        //Create the user and add it to database.
        $u = new User($fullName, $username, $pw, $email, $dob, date("dmy"));
        if($u->createUser()){
            header('Location: '. '../login.php?success=1');

        }else{
            //returns false if the username is taken, so tell the user to choose another name.
            header('Location: ' . '../login.php?error=usernameTaken');
        }
    }else{

        //Passwords didn't match.
        header('Location: '. '../login.php?error=matchPW');
    }
    
    


    

