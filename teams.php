<?php

$league_id = $_GET['name'];

$uri = "http://api.football-data.org/v4/competitions/$league_id/standings";
$reqPrefs['http']['method'] = 'GET';
$reqPrefs['http']['header'] = 'X-Auth-Token: a6c8d6df34f64da0a3d3bbe5beed6ea7';
$stream_context = stream_context_create($reqPrefs);
$response = file_get_contents($uri, false, $stream_context);
$result = json_decode($response, true);

// var_dump($result['standings'][0]['table'][2]['team']['name']);

// var_dump($result['standings'][0]['table']);

// var_dump($merged_array);
?>

<body>
<table>

    <tr>
        <th>Position</th>
        <th>Team</th>
        <th>Played Games</th>
        <th>Won</th>
        <th>Draw</th>
        <th>Lost</th>
        <th>Points</th>
        <th>Goals For</th>
        <th>Goals Against</th>
        <th>Goal Difference</th>
    </tr>
    <tr>
        <td>
            <?php
            foreach ($result['standings'][0]['table'] as $standing) {
            echo "<tr>";
            echo "<td>" . $standing['position'] . "</td>";
            echo "<td><img src='" . $standing['team']['crest'] . "' height='22' width='22'> <a href='/index.php?page=team&id=" . $standing["team"]["id"] ."'>" .  $standing['team']['name'] . '</a></td>';
            echo "<td>" . $standing['playedGames'] . "</td>";
            echo "<td>" . $standing['won'] . "</td>";
            echo "<td>" . $standing['draw'] . "</td>";
            echo "<td>" . $standing['lost'] . "</td>";
            echo "<td>" . $standing['points'] . "</td>";
            echo "<td>" . $standing['goalsFor'] . "</td>";
            echo "<td>" . $standing['goalsAgainst'] . "</td>";
            echo "<td>" . $standing['goalDifference'] . "</td>";
            echo "</tr>";
            }
            ?>
        </td>
    </tr>

</table>

</body>
