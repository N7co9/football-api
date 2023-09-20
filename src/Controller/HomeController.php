<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Api\ApiHandling;
use App\Core\Api\ApiMapper;
use App\Core\Container;
use App\Core\View;

class HomeController implements ControllerInterface
{
    private View $templateEngine;

    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(View::class);
        $this->ApiMapper = $container->get(ApiMapper::class);
    }

    public function dataConstruct(): View
    {
        $result = new ApiHandling($this->ApiMapper);
        $result = $result->getCompetitions();
        $this->templateEngine->setTemplate('home.twig');
        $this->templateEngine->addParameter('competitions', $result);
        $this->templateEngine->addParameter('user', $_SESSION['mail'] ?? null);

        return $this->templateEngine;
    }
}
