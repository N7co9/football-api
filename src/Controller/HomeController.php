<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Container;
use App\Core\View;

class HomeController implements ControllerInterface
{
    public function __construct(private readonly Container $container)
    {
        $this->templateEngine = $this->container->get(View::class);
    }

    public function dataConstruct() : object
    {
        $result = ApiHandling::makeApiRequest('http://api.football-data.org/v4/competitions');
        $this->templateEngine->setTemplate('home.twig');
        $this->templateEngine->addParameter('competitions', $result['competitions']);
        $this->templateEngine->addParameter('user', $_SESSION['mail'] ?? null);

        return $this->templateEngine;
    }
}
