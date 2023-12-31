<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Api\ApiHandling;
use App\Core\Api\ApiMapper;
use App\Core\Container;
use App\Core\View;

class TeamController implements ControllerInterface
{
    private View $templateEngine;

    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(View::class);
        $this->ApiMapper = $container->get(ApiMapper::class);
    }

    public function dataConstruct(): object
    {
        $leagueId = $_GET['name'];

        $result = new ApiHandling($this->ApiMapper);
        $result = $result->getStandings($leagueId);

        $this->templateEngine->addParameter('standings', $result);
        $this->templateEngine->setTemplate('competition.twig');

        return $this->templateEngine;
    }
}