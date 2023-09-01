<?php
declare(strict_types=1);

namespace MyProject;

use core\View;
use JsonException;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class HomeController implements ControllerInterface
{

    public function __construct(private View $templateEngine)
    {

    }

    public function dataConstruct(): void
    {
        $result = ApiHandling::makeApiRequest('http://api.football-data.org/v4/competitions/');
        $this->templateEngine->addParameter('competitions', $result['competitions']);
        $this->templateEngine->addParameter('user', $_SESSION['mail'] ?? null);
        $this->templateEngine->display('home.twig');
    }

}