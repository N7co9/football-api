<?php
declare(strict_types=1);
session_start();

//   -----> validate inputs here <-------


$sessionMail = "";
$sessionName = "";
$err = "";
$errPass = "";
$errMail = "";
$errName = "";

$_SESSION['name'] = $_POST['name'];
$_SESSION['mail'] = $_POST['mail'];

if(isset($_SESSION['name'])){
    $sessionName = $_SESSION['name'];
}

if(isset($_SESSION['mail'])){
    $sessionMail = $_SESSION['mail'];
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!empty($_POST['name']) && preg_match("/^[a-zA-Z-' ]*$/", $_POST['name'])) {
        $validName = $_POST['name'];
    } else {
        $validName = '';
        $errName = 'Hoops, your name doesnt look right!';
    }

    if (!empty($_POST['mail'] && filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))) {
        $validEmail = $_POST['mail'];
    } else {
        $validEmail = '';
        $errMail = 'Hoops, your email doesnt look right!';
    }

    if (!empty($_POST['password'] && preg_match('@[A-Z]@', $_POST['password']) && preg_match('@[a-z]@',
            $_POST['password']) && preg_match('@[0-9]@', $_POST['password']) && preg_match('@[^\w]@', $_POST['password']) && strlen($_POST['password']) > 6)) {
        $validPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
    } else {
        $validPassword = '';
        $errPass = 'Hoops, your password doesnt look right!';
    }

    $jsondumb = file_get_contents(__DIR__ . '/user_data.json');
    $jsonDecode = json_decode($jsondumb);

    $array = json_decode(json_encode($jsonDecode), true);


    $newUser = array(
        'name' => $validName,
        'email' => $validEmail,
        'password' => $validPassword,
    );


    if (!file_exists(__DIR__ . '/user_data.json')) {
        $firstRecord = array($newUser);
        $dataToSave = $firstRecord;
    } else {
        $oldRecords = json_decode(file_get_contents("user_data.json"));
        $oldRecords[] = $newUser;
        $dataToSave = $oldRecords;
    }

    $user_data = json_encode($dataToSave, JSON_PRETTY_PRINT);

    if (!empty($newUser['name'] && !empty($newUser['email'] && !empty($newUser['password'])))) {
        if (!in_array($_POST['mail'], array_column($array, 'email'))) {
            session_abort();
            $sessionName = "";
            $sessionMail = "";
            file_put_contents(__DIR__ . '/user_data.json', $user_data, LOCK_EX);
            $err = "Success! Welcome aboard!";
        } else {
            $err = "Hoops, your Email is already registered";
        }
    } else {
        $err = 'Hoops, your Registration is not complete!';
    }
}
