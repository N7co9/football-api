<?php
declare(strict_types=1);
namespace MyProject;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class SessionController implements ControllerInterface
{
    public function dataConstruct()
    {
        $userData = file_get_contents(__DIR__ . '/../model/userData.json');
        $dataArray = json_decode($userData, true, 512, JSON_THROW_ON_ERROR);

        foreach ($dataArray as $item) {
            $passList [] = $item ['password'];
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($passList as $hash) {
                $valid = password_verify($_POST['password'], $hash);
            }
            if (!empty($valid)  && in_array($_POST['mail'], array_column($dataArray, 'email'), true)) {
                $_SESSION['mail'] = $_POST['mail'];
                $feedback = 'success';
                header('Location: http://localhost:8079/index.php');
            } else {
                $feedback = 'not a valid combination';
            }
        }
        $twig = initTwig();
        echo $twig->render('login.twig', ['feedback' => $feedback ?? null]);
    }
}