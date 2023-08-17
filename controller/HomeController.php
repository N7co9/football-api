<?php
declare(strict_types=1);
namespace MyProject;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class HomeController implements ControllerInterface
{
    public function dataConstruct()
    {
        $result = ApiHandling::makeApiRequest('http://api.football-data.org/v4/competitions/');
        $twig = initTwig();
        echo $twig->render('home.twig', ['competitions' => $result['competitions'], 'user' => $_SESSION['mail'] ?? null]);
    }
}