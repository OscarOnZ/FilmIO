<?php
include_once('functions.php');
$toasts[] = new Toast("oscar", "inception", false);
startSession();
echo base64_encode(serialize($toasts));#
//$users = $thisUser->getSentFriendRequests();
//var_dump($users);

$_SESSION['thisUser']->getSentFriendRequests();


