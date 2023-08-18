<?php
declare(strict_types=1);

use MyProject\ControllerProvider;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . "/vendor/autoload.php";


session_start();                                        // ERROR HANDLING
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


function initTwig(): Environment                                     // TWIG INITIALIZATION
{
    $loader = new FilesystemLoader(__DIR__ . '/view/template/');
    return new Environment($loader);
}

try {
    (new ControllerProvider())->provide();
} catch (JsonException $e) {
}
