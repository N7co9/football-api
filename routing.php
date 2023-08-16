<?php
declare(strict_types=1);

function initializeController($controller, $url) {
    $instance = new $controller();
    $output = $instance->dataConstruct($url);
    $instance->display($output);
}

$request = $_SERVER['REQUEST_URI'];
$query = $_GET;

if ($request === '/' || $request === '/index.php') {
    initializeController('MyProject\HomeController', 'http://api.football-data.org/v4/competitions/');
} elseif ($query['page'] === 'competition') {
    $league_id = $_GET['name'];
    initializeController('MyProject\TeamController', 'http://api.football-data.org/v4/competitions/' . $league_id . '/standings');
} elseif ($query['page'] === 'team') {
    $team_id = $_GET['id'];
    initializeController('MyProject\KaderController', 'http://api.football-data.org/v4/teams/' . $team_id);
} elseif ($query['page'] === 'player') {
    $player_id = $_GET['id'];
    initializeController('MyProject\PlayerController', 'http://api.football-data.org/v4/persons/' . $player_id);
} elseif ($query['page'] === 'registration') {
    $registration = new MyProject\RegistrationController();

    $nmInput = "";
    $emInput = "";
    $pwInput = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nmInput = $_POST['name'];
        $emInput = $_POST['mail'];
        $pwInput = $_POST['password'];
    }

    $output = $registration->dataConstruct($pwInput, $emInput, $nmInput);
    $registration->display(
        $output['err'],
        $output['valueName'],
        $output['valueMail'],
        $output['errName'],
        $output['errMail'],
        $output['errPass']
    );
} elseif ($query['page'] === 'login') {
    $session = new MyProject\SessionController();
    $login = $session->login();
    $session->display($login);
}
