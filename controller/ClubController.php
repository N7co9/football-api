<?php
declare(strict_types=1);

namespace MyProject;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class ClubController implements ControllerInterface
{
    public function dataConstruct()
    {
        $team_id = $_GET['id'];
        $result = ApiHandling::makeApiRequest('http://api.football-data.org/v4/teams/' . $team_id);
        $twig = initTwig();
        echo $twig->render('club.twig', ['result' => $result['squad']]);
    }
}