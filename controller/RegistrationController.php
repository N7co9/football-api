<?php

namespace MyProject;

use model\UserEntityManager;
use model\UserRepository;
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
    public function dataConstruct(): void
    {
        $nameUnverified = $_POST['name'] ?? null;
        $emailUnverified = $_POST['mail'] ?? null;
        $passwordUnverified = $_POST['password'] ?? null;

        $valueName = "";
        $valueMail = "";
        $err = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $valueName = $_POST['name'];
            $valueMail = $_POST['mail'];
        }

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

        }

        $newUser = array(
            'name' => $validName ?? null,
            'email' => $validEmail ?? null,
            'password' => $validPassword ?? null
        );

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($validName) && !empty($validEmail) && !empty($validPassword)) {
                if (empty((new UserRepository())->findByMail($validEmail))) {
                    $valueMail = "";
                    $valueName = "";
                    (new UserEntityManager())->save($newUser);
                    $err = "Success! Welcome aboard!";
                } else {
                    $err = "Hoops, your Email is already registered";
                }
            } else {
                $err = 'Hoops, your Registration is not complete!';
            }
        }

        (new \vendor\TemplateEngine())->render('registration.twig', ['error' => $err, 'vName' => $valueName, 'vMail' => $valueMail, 'eName' => $errName ?? null, 'eMail' => $errMail ?? null, 'ePass' => $errPass ?? null]);
    }
}