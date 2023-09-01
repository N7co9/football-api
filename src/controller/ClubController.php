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

class ClubController implements ControllerInterface
{
    public function __construct(private View $templateEngine)
    {

    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * @throws JsonException
     */
    public function dataConstruct(): void
    {
        $team_id = $_GET['id'];
        $result = ApiHandling::makeApiRequest(url: 'http://api.football-data.org/v4/teams/' . $team_id);
        $this->templateEngine->addParameter('result', $result['squad']);
        $this->templateEngine->display('club.twig');
    }
}