<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\ApiHandling;
use App\Core\ApiMapper;
use App\Core\Container;
use App\Core\View;

class ClubController implements ControllerInterface
{
    private View $templateEngine;
    public string $team_id;

    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(View::class);
        $this->ApiMapper = $container->get(ApiMapper::class);
    }

    public function dataConstruct(): object
    {
        $teamId = $_GET['id'];
        $result = new ApiHandling($this->ApiMapper);
        $result = $result->getTeam($teamId);
        $this->templateEngine->addParameter('team', $result);
        $this->templateEngine->setTemplate('team.twig');

        return $this->templateEngine;
    }
}