<?php

var_dump($result);

foreach ($result->competitions as $VALUE){
    $value [] = $VALUE->name;
    $TEAM_CODE [] = $VALUE->code;
}
// WORKING! :^)
$count = 0;
foreach ($value as $value1){
    echo "<a href='?page=competition&name=$TEAM_CODE[$count]'><ul> $value1 </ul> </a>";
    $count++;
}

// var_dump($teams);

// var_dump($result->competitions[$value]->name);
?>