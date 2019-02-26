<?php

    //for composer
    require_once('C:\Users\oacam\vendor\autoload.php');
    
    use GraphAware\Neo4j\Client\ClientBuilder;
    
    const _SERVERADDRESS = 'bolt://neo4j:1234@localhost:11001';

    //make the client and API key accessible everywhere
    global $client;
    global $apiKey;
    $client = ClientBuilder::create()->addConnection('bolt', _SERVERADDRESS) -> build();
    $apiKey = "31c87b33"; // For IMDB database lookup


    


