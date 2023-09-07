<?php
declare(strict_types=1);

namespace MyProject;

use core\View;
use JsonException;
use model\UserEntityManager;
use model\UserRepository;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class SessionController implements ControllerInterface
{
    public function __construct(private readonly View $templateEngine, private readonly UserEntityManager $userEntityManager, private readonly UserRepository $userRepository)
    {
        $_ = $this->userEntityManager;
    }

    public function dataConstruct(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $verify = (
            $this->userRepository->checkCombo($_POST['mail'], $_POST['password']));                // calls UserRepository, which checks the login credentials and returns a boolean.
            if ($verify === true) {
                $_SESSION['mail'] = $_POST['mail'];
                $feedback = 'success';
                header('Location: http://localhost:8079/index.php');
            } else {
                $feedback = 'not a valid combination';
            }
        }
        $this->templateEngine->addParameter('feedback' , $feedback ?? null);
        $this->templateEngine->display('login.twig');
    }
}
