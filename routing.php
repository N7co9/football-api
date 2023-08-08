<?php
$request = $_SERVER['REQUEST_URI'];
$query = $_GET;


if ($request === '/index.php') {
    require '/home/nicogruenewald/Documents/football-api/home.php';
} else if ($query['page'] == 'competition') {
    require '/home/nicogruenewald/Documents/football-api/teams.php';
} else if ($query['page'] == 'team') {
    require '/home/nicogruenewald/Documents/football-api/kader.php';
} else if ($query['page'] == 'player') {
    require '/home/nicogruenewald/Documents/football-api/player.php';
}
