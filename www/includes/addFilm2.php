<?php
require_once 'functions.php';
global $client;

$film = new Film($_POST['filmID']);
$client->run('CREATE (f:Film{ID:"' . $film->getFilmID() . '", filmName:"' . $film->getName() .'"})');

