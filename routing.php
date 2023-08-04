<?php
$request = $_SERVER['REQUEST_URI'];

var_dump($request);

if($request == '/index.php'){
    require '/home/nicogruenewald/Documents/football-api/home.php';
}
else if($request == '/index.php?page=competition%name=ELC'){
    require '/home/nicogruenewald/Documents/football-api/teams.php';
}
?>