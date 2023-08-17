<?php
declare(strict_types=1);
namespace MyProject;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class PlayerController
{
    public function dataConstruct()
    {
        $player_id = $_GET['id'];
        $ApiRequest = 'http://api.football-data.org/v4/persons/' . $player_id;
        $reqPrefs['http']['method'] = 'GET';
        $reqPrefs['http']['header'] = 'X-Auth-Token: a6c8d6df34f64da0a3d3bbe5beed6ea7';
        $stream_context = stream_context_create($reqPrefs);
        $response = file_get_contents($ApiRequest, false, $stream_context);
        $result = json_decode($response, true);

        $loader = new FilesystemLoader(__DIR__ . '/../view/template');
        $twig = new Environment($loader);
        echo $twig->render('player.twig', ['result' => $result]);
    }

}