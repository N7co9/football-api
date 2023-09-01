<?php
declare(strict_types=1);

namespace MyProject;

use JsonException;
use model\UserEntityManager;
use model\UserRepository;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use core\TemplateEngine;

class SessionController implements ControllerInterface
{
    /**
     * @throws JsonException
     */

    public function __construct(private TemplateEngine $templateEngine, private UserEntityManager $userEntityManager, private UserRepository $userRepository)
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
        $this->templateEngine->render('login.twig', ['feedback' => $feedback ?? null]);
    }
}
