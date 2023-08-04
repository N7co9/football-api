<?php
require_once '/home/nicogruenewald/Documents/football-api/partials/header.php';
require_once '/home/nicogruenewald/Documents/football-api/partials/footer.php';

$uri = 'http://api.football-data.org/v4/competitions/';
$reqPrefs['http']['method'] = 'GET';
$reqPrefs['http']['header'] = 'X-Auth-Token: a6c8d6df34f64da0a3d3bbe5beed6ea7';
$stream_context = stream_context_create($reqPrefs);
$response = file_get_contents($uri, false, $stream_context);
$result = json_decode($response);

require '/home/nicogruenewald/Documents/football-api/routing.php';
?>