<?php declare(strict_types=1);

namespace App\Controller;

use App\Core\Container;
use App\Core\Redirect;
use App\Model\DTO\ErrorDTO;
use App\Model\DTO\UserDTO;
use App\Core\View;
use App\Model\UserEntityManager;
use App\Model\UserRepository;

class RegistrationController implements ControllerInterface
{
    public function __construct(private readonly Container $container)
    {
        $this->templateEngine = $this->container->get(View::class);
        $this->userRepository = $this->container->get(UserRepository::class);
        $this->userEntityManager = $this->container->get(UserEntityManager::class);
    }

    public function dataConstruct(): object
    {
        $userDTO = new UserDTO();
        $userDTO->setName($_POST['name'] ?? '');
        $userDTO->setEmail($_POST['mail'] ?? '');
        $userDTO->setPassword($_POST['password'] ?? '');
        $errorDTOList = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (empty($userDTO->getName()) || !preg_match("/^[a-zA-Z-' ]*$/", $userDTO->getName())) {
                $errorDTOList[] = new ErrorDTO('Oops, your name doesn\'t look right');
            }

            if (empty($userDTO->getEmail()) || !filter_var($userDTO->getEmail(), FILTER_VALIDATE_EMAIL)) {
                $errorDTOList[] = new ErrorDTO('Oops, your email doesn\'t look right');
            }

            if (!empty($userDTO->getPassword() && preg_match('@[A-Z]@', $userDTO->getPassword()) && preg_match('@[a-z]@', $userDTO->getPassword()) &&
                preg_match('@\d@', $userDTO->getPassword()) && preg_match('@\W@', $userDTO->getPassword()) &&
                (strlen($userDTO->getPassword()) > 6))) {
                $validPassword = password_hash(password: $userDTO->getPassword(), algo: PASSWORD_DEFAULT);
            } else {
                $validPassword = '';
                $errorDTOList[] = new ErrorDTO('Oops, your password doesn\'t look right!');
            }

            if (empty($errorDTOList)) {
                $newUser = new UserDTO();
                $newUser->setName($userDTO->getName() ?? '');
                $newUser->setEmail($userDTO->getEmail() ?? '');
                $newUser->setPassword($validPassword);

                if (empty($this->userRepository->findByMail($userDTO->getEmail()) && !empty($userDTO->getPassword()))) {
                    $this->userEntityManager->save($newUser);
                    $errorDTOList[] = new ErrorDTO('Success. Welcome abroad!');
                    $userDTO->setName('');
                    $userDTO->setEmail('');
                } else {
                    $errorDTOList[] = new ErrorDTO('Oops, your email is already registered!');
                }
            }
        }
        $this->templateEngine->setTemplate('registration.twig');
        $this->templateEngine->addParameter('user', $userDTO);
        $this->templateEngine->addParameter('vName', $userDTO->getName());
        $this->templateEngine->addParameter('vMail', $userDTO->getEmail());
        $this->templateEngine->addParameter('errors', $errorDTOList);

        return $this->templateEngine;
    }
}