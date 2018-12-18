<?php
require_once ('functions.php');
if(checkRelationExists("oscar", "1300854", "film", "likes")){
    echo "true";
}else{
    echo "false";
}
?>
