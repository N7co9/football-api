<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Container;
use App\Core\Redirect;
use App\Core\View;
use App\Model\UserEntityManager;
use App\Model\UserRepository;


class SessionController implements ControllerInterface
{
    public function __construct(private readonly Container $container)
    {
        $this->templateEngine = $this->container->get(View::class);
        $this->userRepository = $this->container->get(UserRepository::class);
        $this->redirect = $this->container->get(Redirect::class);
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
