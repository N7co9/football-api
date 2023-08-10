<?php
declare(strict_types=1);
$request = $_SERVER['REQUEST_URI'];
$query = $_GET;

if ($request === '/') {
    require __DIR__ . '/controller/home.php';
} else if ($request === '/index.php') {
    require __DIR__ . '/controller/home.php';
} else if ($query['page'] == 'competition') {
    require __DIR__ . '/controller/teams.php';
} else if ($query['page'] == 'team') {
    require __DIR__ . '/controller/kader.php';
} else if ($query['page'] == 'player') {
    require __DIR__ . '/controller/player.php';
} else if ($query['page'] === 'registration') {
    require __DIR__ . '/controller/user.php';
} else if ($query['page'] === 'login') {
    require __DIR__ . '/controller/login.php';
}
