<!DOCTYPE html>
<html lang="en">
<head>
    <title>football-api</title>
</head>

<!-- insert API Connection here -->

<?php
$uri = 'http://api.football-data.org/v4/competitions/';
$reqPrefs['http']['method'] = 'GET';
$reqPrefs['http']['header'] = 'X-Auth-Token: a6c8d6df34f64da0a3d3bbe5beed6ea7';
$stream_context = stream_context_create($reqPrefs);
$response = file_get_contents($uri, false, $stream_context);
$result = json_decode($response);

?>

<body>

<?php

foreach ($result->competitions as $VALUE){
    $value [] = $VALUE->name;
}

foreach ($value as $value1){
    echo "<a href='#'><ul> $value1 </ul> </a>";
}


//var_dump($value);

// var_dump($result->competitions[$value]->name);
?>

The content of the document......

</body>

</html> 