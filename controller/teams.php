<?php
declare(strict_types=1);

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$league_id = $_GET['name'];

$uri = "http://api.football-data.org/v4/competitions/$league_id/standings";
$reqPrefs['http']['method'] = 'GET';
$reqPrefs['http']['header'] = 'X-Auth-Token: a6c8d6df34f64da0a3d3bbe5beed6ea7';
$stream_context = stream_context_create($reqPrefs);
$response = file_get_contents($uri, false, $stream_context);
$result = json_decode($response, true);

$loader = new FilesystemLoader(__DIR__ . '/../view/template');
$twig = new Environment($loader);

echo $twig->render('teams.twig', ['standings' => $result['standings']]);

