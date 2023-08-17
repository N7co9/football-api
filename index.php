<?php
declare(strict_types=1);

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . "/vendor/autoload.php";

session_start();                                        // ERROR HANDLING
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

function initTwig()                                     // TWIG INITIALIZATION
{
    $loader = new FilesystemLoader(__DIR__ . '/view/template/');
    return new Environment($loader);
}

function initializeController($controller)              // TEMPORARY ROUTING SOLUTION
{
    $instance = new $controller();
    $instance->dataConstruct();
}

$request = $_SERVER['REQUEST_URI'];
$query = $_GET;

if ($request === '/' || $request === '/index.php') {
    initializeController(\MyProject\HomeController::class);
} elseif ($query['page'] === 'competition') {
    initializeController(\MyProject\TeamController::class);
} elseif ($query['page'] === 'team') {
    initializeController(\MyProject\ClubController::class);
} elseif ($query['page'] === 'player') {
    initializeController(\MyProject\PlayerController::class);
} elseif ($query['page'] === 'registration') {
    initializeController(\MyProject\RegistrationController::class);
} elseif ($query['page'] === 'login') {
    initializeController(\MyProject\SessionController::class);
} elseif ($query['page'] === 'logout') {
    initializeController(\MyProject\LogoutController::class);
}
