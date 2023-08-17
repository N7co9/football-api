<?php

namespace MyProject;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class RegistrationController
{
    public function dataConstruct()
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
                    $passwordUnverified) && preg_match('@[0-9]@', $passwordUnverified) && preg_match('@[^\w]@', $passwordUnverified) && strlen($passwordUnverified) > 6)) {
                $validPassword = password_hash($passwordUnverified, PASSWORD_DEFAULT);
            } else {
                $validPassword = '';
                $errPass = 'Hoops, your password doesnt look right!';
            }

            $newUser = array(
                'name' => $validName,
                'email' => $validEmail,
                'password' => $validPassword,
            );
        }

        $jsondumb = file_get_contents(__DIR__ . '/../model/userData.json');
        $jsonDecode = json_decode($jsondumb);

        $array = json_decode(json_encode($jsonDecode), true);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!file_exists(__DIR__ . '/../model/userData.json')) {
                $firstRecord = array($newUser);
                $dataToSave = $firstRecord;
            } else {
                $oldRecords = json_decode(file_get_contents(__DIR__ . '/../model/userData.json'));
                $oldRecords[] = $newUser;
                $dataToSave = $oldRecords;
            }

            $user_data = json_encode($dataToSave, JSON_PRETTY_PRINT);

            if (!empty($newUser['name'] && !empty($newUser['email'] && !empty($newUser['password'])))) {
                if (!in_array($validEmail, array_column($array, 'email'))) {
                    $valueMail = "";
                    $valueName = "";
                    file_put_contents(__DIR__ . '/../model/userData.json', $user_data, LOCK_EX);
                    $err = "Success! Welcome aboard!";
                } else {
                    $err = "Hoops, your Email is already registered";
                }
            } else {
                $err = 'Hoops, your Registration is not complete!';
            }
        }

        $loader = new FilesystemLoader(__DIR__ . '/../view/template');
        $twig = new Environment($loader);
        echo $twig->render('registration.twig', ['error' => $err, 'vName' => $valueName, 'vMail' => $valueMail, 'eName' => $errName ?? null, 'eMail' => $errMail ?? null, 'ePass' => $errPass ?? null]);
    }
}