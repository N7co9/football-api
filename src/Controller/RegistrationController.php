<?php declare(strict_types=1);

namespace App\Controller;

use App\Core\Container;
use App\Core\Validator;
use App\Model\DTO\ErrorDTO;
use App\Model\DTO\UserDTO;
use App\Core\View;
use App\Model\UserEntityManager;
use App\Model\UserRepository;

class RegistrationController implements ControllerInterface
{
    public Validator $validator;
    private UserEntityManager $userEntityManager;
    public View $templateEngine;
    private userRepository $userRepository;
    public array $errorDTOList;

    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(View::class);
        $this->userRepository = $container->get(UserRepository::class);
        $this->userEntityManager = $container->get(UserEntityManager::class);
        $this->validator = $container->get(Validator::class);
    }

    public function dataConstruct(): object
    {
        $userDTO = new UserDTO();
        $userDTO->name = ($_POST['name'] ?? '');
        $userDTO->email = ($_POST['mail'] ?? '');
        $userDTO->passwort = ($_POST['passwort'] ?? '');
        $this->errorDTOList = [];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $validator = $this->validator;
            $this->errorDTOList = $validator->validate($userDTO);

            if (empty($this->errorDTOList)) {
                $validPassword = password_hash(password: $userDTO->passwort, algo: PASSWORD_DEFAULT);

                $newUser = new UserDTO();
                $newUser->name = ($userDTO->name ?? '');
                $newUser->email = ($userDTO->email ?? '');
                $newUser->passwort = ($validPassword);

                if (empty($this->userRepository->findByMail($userDTO->email) && !empty($userDTO->passwort))) {
                    $this->userEntityManager->save($newUser);
                    $this->errorDTOList [] = new ErrorDTO('Success. Welcome abroad!');
                    $userDTO->name = ('');
                    $userDTO->passwort = ('');
                    $userDTO->email = ('');
                } else {
                    $this->errorDTOList [] = new ErrorDTO('Oops, your email is already registered!');
                }
            }
        }
        $this->templateEngine->setTemplate('registration.twig');
        $this->templateEngine->addParameter('user', $userDTO);
        $this->templateEngine->addParameter('vName', $userDTO->name);
        $this->templateEngine->addParameter('vMail', $userDTO->email);
        $this->templateEngine->addParameter('errors', $this->errorDTOList);

        return $this->templateEngine;
    }
}