<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Redirect;
use App\Core\View;
use App\Model\UserEntityManager;
use App\Model\UserRepository;


class SessionController implements ControllerInterface
{
    public function __construct(private readonly View $templateEngine, private readonly UserEntityManager $userEntityManager, private readonly UserRepository $userRepository, private readonly Redirect $redirect)
    {
        $_ = $this->userEntityManager;
    }

    public function dataConstruct(): object
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $verify = (
            $this->userRepository->checkCombo($_POST['mail'], $_POST['password']));                // calls UserRepository, which checks the login credentials and returns a boolean.
            if ($verify === true) {
                $_SESSION['mail'] = $_POST['mail'];
                $feedback = 'success';
                $this->redirect->to('');
            } else {
                $feedback = 'not a valid combination';
            }
        }
        $this->templateEngine->setTemplate('login.twig');
        $this->templateEngine->addParameter('feedback', $feedback ?? '');

        return $this->templateEngine;
    }
}
