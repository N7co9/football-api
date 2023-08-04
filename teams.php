<?php

$league_id = $_GET['name'];

$uri = "http://api.football-data.org/v2/competitions/$league_id/standings";
$reqPrefs['http']['method'] = 'GET';
$reqPrefs['http']['header'] = 'X-Auth-Token: a6c8d6df34f64da0a3d3bbe5beed6ea7';
$stream_context = stream_context_create($reqPrefs);
$response = file_get_contents($uri, false, $stream_context);
$result = json_decode($response, true);

var_dump($result['standings'][0]);

?>

?>
<body>
<table>
    <tr>
        <th>Position  </th>
        <th>Team  </th>
        <th>Played Games  </th>
        <th>Won  </th>
        <th>Draw  </th>
        <th>Lost  </th>
        <th>Points  </th>
        <th>Goals For  </th>
        <th>Goals Against  </th>
        <th>Goal Difference  </th>
    </tr>
    <tr>
        <?php
        $count = 0;
foreach ($result['teams'] as $team) {
    $name [] = $team['name'];
    echo "<td> $name[$count] </td> <tr></tr>";
    $count++;
}
        ?>
    </tr>

</table>

</body>
