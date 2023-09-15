<?php
declare(strict_types=1);

namespace App\Controller;


use App\Core\Container;
use App\Core\View;
use JsonException;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class PlayerController implements ControllerInterface
{
    private View $templateEngine;

    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(View::class);
    }

    public function dataConstruct(): View
    {
        $playerId = $_GET['id'];
        $result = ApiHandling::makeApiRequest('http://api.football-data.org/v4/persons/' . $playerId);
        $this->templateEngine->addParameter('player', $result);
        $this->templateEngine->setTemplate('player.twig');

        return $this->templateEngine;
    }
}