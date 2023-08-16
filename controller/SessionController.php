<?php
declare(strict_types=1);

namespace MyProject;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class SessionController
{

    public function login()
    {

        $userData = file_get_contents(__DIR__ . '/../model/userData.json');
        $dataArray = json_decode($userData, true);


        foreach ($dataArray as $item) {
            $passList [] = $item ['password'];
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            foreach ($passList as $hash) {
                $valid = password_verify($_POST['password'], $hash);
            }

            if (in_array($_POST['mail'], array_column($dataArray, 'email')) && !empty($valid)) {
                $_SESSION['mail'] = $_POST['mail'];
                $feedback = 'success';
                header('Location: http://localhost:8079/index.php');
            } else {
                $feedback = 'not a valid combination';
            }

        }
        return $feedback ?? null;
    }


    public function display($feedback)
    {
        $loader = new FilesystemLoader(__DIR__ . '/../view/template');
        $twig = new Environment($loader);
        echo $twig->render('login.twig', ['feedback' => $feedback ?? null]);
    }
}