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
    private View $templateEngine;
    public string $team_id;

    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(View::class);
        $this->team_id = $_GET['id'] ?? '';
    }

    public function dataConstruct(): object
    {
        $result = ApiHandling::makeApiRequest(url: 'http://api.football-data.org/v4/teams/' . $this->team_id);
        $this->templateEngine->addParameter('team', $result['squad'] ?? '');
        $this->templateEngine->setTemplate('team.twig');

        return $this->templateEngine;
    }
}