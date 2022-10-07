<?php 
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    require __DIR__."/./config.php";
    require __DIR__."/./Item_class.php";

    $config = new Config_db();
    $db = $config->connect();
    $item = new Items($db);
    $item->businessMatric();
    
    
?>