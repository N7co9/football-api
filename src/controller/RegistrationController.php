<?php declare(strict_types=1);

namespace MyProject;

use core\View;
use model\userDTO;
use model\UserEntityManager;
use model\UserRepository;
use PHPUnit\Logging\Exception;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class RegistrationController implements ControllerInterface
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */

    public function __construct(private View $templateEngine, private UserEntityManager $userEntityManager, private UserRepository $userRepository)
    {
    }

    public function dataConstruct(): void
    {
        $err = '';

        $nameUnverified = $_POST['name'] ?? '';
        $emailUnverified = $_POST['mail'] ?? '';
        $passwordUnverified = $_POST['password'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($nameUnverified) && preg_match("/^[a-zA-Z-' ]*$/", $nameUnverified)) {
                $validName = $nameUnverified;
            } else {
                $validName = '';
                $errName = 'Hoops, your name doesnt look right!';
            }

            if (!empty($emailUnverified && filter_var($emailUnverified, FILTER_VALIDATE_EMAIL))) {
                $validEmail = $emailUnverified;
            } else {
                $validEmail = '';
                $errMail = 'Hoops, your email doesnt look right!';
            }

            if (!empty($passwordUnverified && preg_match('@[A-Z]@', $passwordUnverified) && preg_match('@[a-z]@',
                    $passwordUnverified) && preg_match('@\d@', $passwordUnverified) && preg_match('@\W@', $passwordUnverified) && (strlen($passwordUnverified) > 6))) {
                $validPassword = password_hash(password: $passwordUnverified, algo: PASSWORD_DEFAULT);
            } else {
                $validPassword = '';
                $errPass = 'Hoops, your password doesnt look right!';
            }

            $newUser = new userDTO();
            $newUser->setName($validName);
            $newUser->setEmail($validEmail);
            $newUser->setPassword($validPassword);

            if (!empty($validName) && !empty($validEmail) && !empty($validPassword)) {
                if (empty($this->userRepository->findByMail($validEmail))) {
                    $nameUnverified = "";
                    $emailUnverified = "";
                    $this->userEntityManager->save($newUser);
                    $err = "Success! Welcome aboard!";
                } else if (!empty($this->userRepository->findByMail($validEmail))) {
                    $err = "Hoops, your Email is already registered";
                }
            } else {
                $err = 'Hoops, your Registration is not complete!';
            }
        }

        $this->templateEngine->addParameter('error' , $err);
        $this->templateEngine->addParameter('vName' , $nameUnverified);
        $this->templateEngine->addParameter('vMail' , $emailUnverified);
        $this->templateEngine->addParameter('eName' , $errName ?? null);
        $this->templateEngine->addParameter('eMail' , $errMail ?? null);
        $this->templateEngine->addParameter('ePass' , $errPass ?? null);

        $this->templateEngine->display('registration.twig');    }
}