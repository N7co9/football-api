<?php

$team_id = $_GET['id'];

$uri = "http://api.football-data.org/v4/teams/$team_id";
$reqPrefs['http']['method'] = 'GET';
$reqPrefs['http']['header'] = 'X-Auth-Token: a6c8d6df34f64da0a3d3bbe5beed6ea7';
$stream_context = stream_context_create($reqPrefs);
$response = file_get_contents($uri, false, $stream_context);
$result = json_decode($response, true);


echo "<h1>Kader</h1>";

$count = -1;
foreach ($result['squad'] as $item) {
    $count++;
    $new_list [] = $item;
    echo "<ul>" . "<li>" . "<a" . " href='/index.php?page=player&id=" . $new_list[$count]['id'] . "'>" . $new_list[$count]['name'] . "</a>" . "</li>" . "</ul>";
}



// var_dump($new_list[0]['id']);

