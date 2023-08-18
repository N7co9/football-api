<?php
declare(strict_types=1);

namespace MyProject;

use JsonException;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class PlayerController implements ControllerInterface
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * @throws JsonException
     */
    public function dataConstruct(): void
    {
        $player_id = $_GET['id'];
        $result = ApiHandling::makeApiRequest('http://api.football-data.org/v4/persons/' . $player_id);
        (new \vendor\TemplateEngine())->render('player.twig', ['result' => $result]);
    }

}