<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Container;
use App\Core\View;

class TeamController implements ControllerInterface
{
    private View $templateEngine;
    public string $league_id;

    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(View::class);
        $this->league_id = $_GET['name'] ?? '';
    }

    public function dataConstruct(): object
    {
        $result = ApiHandling::makeApiRequest('http://api.football-data.org/v4/competitions/' . $this->league_id . '/standings');

        $this->templateEngine->addParameter('standings', $result['standings']);
        $this->templateEngine->setTemplate('competition.twig');

        return $this->templateEngine;
    }
}