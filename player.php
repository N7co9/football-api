<?php

$player_id = $_GET['id'];

$uri = "http://api.football-data.org/v4/persons/$player_id";
$reqPrefs['http']['method'] = 'GET';
$reqPrefs['http']['header'] = 'X-Auth-Token: a6c8d6df34f64da0a3d3bbe5beed6ea7';
$stream_context = stream_context_create($reqPrefs);
$response = file_get_contents($uri, false, $stream_context);
$result = json_decode($response, true);


echo "<h1>" . $result['name'] . "</h1>";

echo "<ul>" . "<li>" . "Position: " . $result['position'] . "</li>" .
    "<li>" . "Geburtsdatum: " . $result['dateOfBirth'] . "</li>" .
    "<li>" . "Nationalität: " . $result['nationality'] . "</li>" .
    "<li>" . "Trikotnummer: " . $result['shirtNumber'] . "</li>" .
    "</ul>";
