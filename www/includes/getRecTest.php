<?php
require_once( $_SERVER['DOCUMENT_ROOT']. "./includes/functions.php");

$films = getRecommendations("oscar");
foreach($films as $film){
    echo $film . ',';
}