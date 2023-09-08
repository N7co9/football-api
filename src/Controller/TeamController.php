<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\View;

class TeamController implements ControllerInterface
{

    public function __construct(private readonly View $templateEngine)
    {

    }

    public function dataConstruct(): object
    {
        $league_id = $_GET['name'];
        $result = ApiHandling::makeApiRequest('http://api.football-data.org/v4/competitions/' . $league_id . '/standings');

        $this->templateEngine->addParameter('standings', $result['standings']);
        $this->templateEngine->setTemplate('competition.twig');

        return $this->templateEngine;
    }
}