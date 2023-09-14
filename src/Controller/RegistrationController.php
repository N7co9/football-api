<?php declare(strict_types=1);

namespace App\Controller;

use App\Core\Container;
use App\Model\DTO\ErrorDTO;
use App\Model\DTO\UserDTO;
use App\Core\View;
use App\Model\UserEntityManager;
use App\Model\UserRepository;

class RegistrationController implements ControllerInterface
{
    private UserEntityManager $userEntityManager;
    private View $templateEngine;
    private userRepository $userRepository;

    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(View::class);
        $this->userRepository = $container->get(UserRepository::class);
        $this->userEntityManager = $container->get(UserEntityManager::class);
    }

    public function dataConstruct(): object
    {
        $userDTO = new UserDTO();
        $userDTO->name = ($_POST['name'] ?? '');
        $userDTO->email = ($_POST['mail'] ?? '');
        $userDTO->password = ($_POST['password'] ?? '');
        $errorDTOList = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (empty($userDTO->name) || !preg_match("/^[a-zA-Z-' ]*$/", $userDTO->name)) {
                $errorDTOList[] = new ErrorDTO('Oops, your name doesn\'t look right');
            }

            if (empty($userDTO->email) || !filter_var($userDTO->email, FILTER_VALIDATE_EMAIL)) {
                $errorDTOList[] = new ErrorDTO('Oops, your email doesn\'t look right');
            }

            if (!empty($userDTO->password && preg_match('@[A-Z]@', $userDTO->password) && preg_match('@[a-z]@', $userDTO->password) &&
                preg_match('@\d@', $userDTO->password) && preg_match('@\W@', $userDTO->password) &&
                (strlen($userDTO->password) > 6))) {
                $validPassword = password_hash(password: $userDTO->password, algo: PASSWORD_DEFAULT);
            } else {
                $validPassword = '';
                $errorDTOList[] = new ErrorDTO('Oops, your password doesn\'t look right!');
            }

            if (empty($errorDTOList)) {
                $newUser = new UserDTO();
                $newUser->name = ($userDTO->name ?? '');
                $newUser->email = ($userDTO->email ?? '');
                $newUser->password = ($validPassword);

                if (empty($this->userRepository->findByMail($userDTO->email) && !empty($userDTO->password))) {
                    $this->userEntityManager->save($newUser);
                    $errorDTOList[] = new ErrorDTO('Success. Welcome abroad!');
                    $userDTO->password = ('');
                    $userDTO->email = ('');
                } else {
                    $errorDTOList[] = new ErrorDTO('Oops, your email is already registered!');
                }
            }
        }
        $this->templateEngine->setTemplate('registration.twig');
        $this->templateEngine->addParameter('user', $userDTO);
        $this->templateEngine->addParameter('vName', $userDTO->name);
        $this->templateEngine->addParameter('vMail', $userDTO->email);
        $this->templateEngine->addParameter('errors', $errorDTOList);

        return $this->templateEngine;
    }
}