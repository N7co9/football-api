<?php
declare(strict_types=1);

use Twig\Loader\FilesystemLoader;
use Twig\Environment;


$userData = file_get_contents(__DIR__ . '/../model/user_data.json');
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
        header('Location: http://localhost:8000/index.php');
    } else {
        $feedback = 'not a valid combination';
    }

}


$loader = new FilesystemLoader(__DIR__ . '/../view/template');
$twig = new Environment($loader);

echo $twig->render('login.twig', ['feedback' => $feedback ?? null]);
