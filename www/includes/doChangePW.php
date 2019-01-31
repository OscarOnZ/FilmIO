<?php
/**
 * Copyright (c) Oscar Cameron 2019.
 */

/**
 * Created by PhpStorm.
 * User: oacam
 * Date: 30/01/2019
 * Time: 11:20
 */
include_once('functions.php');
startSession();
if(isset($_POST['newPW'])){
    $_SESSION['thisUser']->changePassword($_POST['newPW']);
    header("location: ../index.php");
}
else{
    echo "no new pw";
}
