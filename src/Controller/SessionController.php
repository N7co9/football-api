<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Container;
use App\Core\Redirect;
use App\Core\View;
use App\Model\DTO\UserDTO;
use App\Model\UserRepository;


class SessionController implements ControllerInterface
{
    private Redirect $redirect;
    private View $templateEngine;
    private userRepository $userRepository;
    private UserDTO $UserDTO;

    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(View::class);
        $this->userRepository = $container->get(UserRepository::class);
        $this->redirect = $container->get(Redirect::class);
        $this->UserDTO = $container->get(UserDTO::class);
    }

    public function dataConstruct(): object
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->UserDTO->email = $_POST['mail'] ?? '';
            $this->UserDTO->passwort = $_POST['passwort'] ?? '';

            $verify = (
            $this->userRepository->checkLoginCredentials($this->UserDTO));                // calls UserRepository, which checks the login credentials and returns a boolean.
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
