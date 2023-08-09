<?php
declare(strict_types=1);
$request = $_SERVER['REQUEST_URI'];
$query = $_GET;


if ($request === '/index.php') {
    require __DIR__ . '/home.php';
} else if ($query['page'] == 'competition') {
    require __DIR__ . '/teams.php';
} else if ($query['page'] == 'team') {
    require __DIR__ . '/kader.php';
} else if ($query['page'] == 'player') {
    require __DIR__ . '/player.php';
}
