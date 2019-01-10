<?php

    require_once('C:\Users\oacam\vendor\autoload.php');
    
    use GraphAware\Neo4j\Client\ClientBuilder;
    
    const _SERVERADDRESS = 'bolt://neo4j:1234@localhost:7687';
    
    global $client;
    global $apiKey;
    $client = ClientBuilder::create() -> addConnection('bolt', _SERVERADDRESS) -> build();
    $apiKey = "31c87b33";
    
    /*
     * The Sacred Texts
     *
     *
     $result = $client->run("MATCH(n:Person) RETURN n");
     $record = $result->firstRecord();
     $node = $record->nodeValue("n");
     echo $node->value("FirstName");
     
     */


    


