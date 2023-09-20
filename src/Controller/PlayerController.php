<?php
declare(strict_types=1);

namespace App\Controller;


use App\Core\Api\ApiHandling;
use App\Core\Api\ApiMapper;
use App\Core\Container;
use App\Core\View;

class PlayerController implements ControllerInterface
{
    private View $templateEngine;

    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(View::class);
        $this->ApiMapper = $container->get(ApiMapper::class);
    }

    public function dataConstruct(): View
    {
        $playerId = $_GET['id'];
        $result = new ApiHandling($this->ApiMapper);
        $result = $result->getPerson($playerId);
        $this->templateEngine->addParameter('player', $result);
        $this->templateEngine->setTemplate('player.twig');

        return $this->templateEngine;
    }
}