<?php
declare(strict_types=1);

namespace MyProject;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;


class TeamController implements ControllerInterface
{
    public function dataConstruct()
    {
        $league_id = $_GET['name'];
        $result = ApiHandling::makeApiRequest('http://api.football-data.org/v4/competitions/' . $league_id . '/standings');
        $twig = initTwig();
        echo $twig->render('teams.twig', ['standings' => $result['standings']]);
    }
}