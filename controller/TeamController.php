<?php
declare(strict_types=1);

namespace MyProject;

use JsonException;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use vendor\TemplateEngine;


class TeamController implements ControllerInterface
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * @throws JsonException
     */

    public function __construct(private TemplateEngine $templateEngine)
    {

    }

    public function dataConstruct(): void
    {
        $league_id = $_GET['name'];
        $result = ApiHandling::makeApiRequest('http://api.football-data.org/v4/competitions/' . $league_id . '/standings');
        $this->templateEngine->render('teams.twig', ['standings' => $result['standings']]);
    }
}