<?php
$data = file_get_contents("http://www.omdbapi.com/?apikey=31c87b33&i=tt". 2527336);
$filmInfo = json_decode($data);
echo $filmInfo->Title;
