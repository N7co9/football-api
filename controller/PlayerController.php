<?php
declare(strict_types=1);
namespace MyProject;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class PlayerController implements ControllerInterface
{
    public function dataConstruct()
    {
        $player_id = $_GET['id'];
        $result = ApiHandling::makeApiRequest('http://api.football-data.org/v4/persons/' . $player_id);
        $twig = initTwig();
        echo $twig->render('player.twig', ['result' => $result]);
    }

}