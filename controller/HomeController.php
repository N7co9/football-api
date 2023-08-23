<?php
declare(strict_types=1);

namespace MyProject;

use JsonException;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use vendor\TemplateEngine;

class HomeController implements ControllerInterface
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
        $result = ApiHandling::makeApiRequest('http://api.football-data.org/v4/competitions/');
        $this->templateEngine->render('home.twig', ['competitions' => $result['competitions'], 'user' => $_SESSION['mail'] ?? null]);
    }

}