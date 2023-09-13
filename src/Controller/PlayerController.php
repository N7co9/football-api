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
    public function __construct(private readonly Container $container)
    {
        $this->templateEngine = $this->container->get(View::class);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * @throws JsonException
     */
    public function dataConstruct(): object
    {
        $player_id = $_GET['id'] ?? '1337';
        $result = ApiHandling::makeApiRequest('http://api.football-data.org/v4/persons/' . $player_id);
        $this->templateEngine->addParameter('player', $result);
        $this->templateEngine->setTemplate('player.twig');

        return $this->templateEngine;
    }
}