<?php
/**
 * Copyright (c) Oscar Cameron 2018.
 */

require_once 'functions.php';
if(isset($_GET['text'])){
    global $client;
    $names = [];
    $result = $client->run("START n = node(*) WHERE lower(n.filmName) CONTAINS lower('" . $_GET['text'] ."') RETURN n, n.filmName as name");
    $records = $result->records();
    foreach($records as $record){
        $names[] = $record->value("name");

    }
    foreach($names as $name){
        echo $name;
    }

}