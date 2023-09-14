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
    public string $player_id;

    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(View::class);
        $this->player_id = $_GET['id'] ?? '';
    }

    public function dataConstruct(): object
    {
        $result = ApiHandling::makeApiRequest('http://api.football-data.org/v4/persons/' . $this->player_id);
        $this->templateEngine->addParameter('player', $result);
        $this->templateEngine->setTemplate('player.twig');

        return $this->templateEngine;
    }
}