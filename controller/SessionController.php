<?php
declare(strict_types=1);

namespace MyProject;

use model\UserRepository;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class SessionController implements ControllerInterface
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function dataConstruct(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $verify = (new UserRepository())->checkCombo($_POST['mail'], $_POST['password']);               // calls UserRepository, which checks the login credentials and returns a boolean.
            if ($verify === true) {
                $_SESSION['mail'] = $_POST['mail'];
                $feedback = 'success';
                header('Location: http://localhost:8079/index.php');
            } else {
                $feedback = 'not a valid combination';
            }
        }
        (new \vendor\TemplateEngine())->render('login.twig', ['feedback' => $feedback ?? null]);
    }
}
