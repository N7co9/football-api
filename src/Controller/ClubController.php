<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Container;
use App\Core\View;
use JsonException;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class ClubController implements ControllerInterface
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
        $team_id = $_GET['id'] ?? '';
        $result = ApiHandling::makeApiRequest(url: 'http://api.football-data.org/v4/teams/' . $team_id);
        $this->templateEngine->addParameter('team', $result['squad'] ?? '');
        $this->templateEngine->setTemplate('team.twig');

        return $this->templateEngine;
    }
}