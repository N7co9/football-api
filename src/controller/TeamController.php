<?php
declare(strict_types=1);

namespace MyProject;

use core\View;
use JsonException;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;


class TeamController implements ControllerInterface
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * @throws JsonException
     */

    public function __construct(private View $templateEngine)
    {

    }

    public function dataConstruct(): void
    {
        $league_id = $_GET['name'];
        $result = ApiHandling::makeApiRequest('http://api.football-data.org/v4/competitions/' . $league_id . '/standings');
        $this->templateEngine->addParameter('standings', $result['standings']);
        $this->templateEngine->display('teams.twig');
    }
}