<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Container;
use App\Core\View;

class TeamController implements ControllerInterface
{

    public function __construct(private readonly Container $container)
    {
        $this->templateEngine = $this->container->get(View::class);
    }

    public function dataConstruct(): object
    {
        $league_id = $_GET['name'] ?? 'BSA';
        $result = ApiHandling::makeApiRequest('http://api.football-data.org/v4/competitions/' . $league_id . '/standings');

        $this->templateEngine->addParameter('standings', $result['standings']);
        $this->templateEngine->setTemplate('competition.twig');

        return $this->templateEngine;
    }
}