<?php
declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";

session_start();                                        // ERROR HANDLING
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$provider = new \App\Controller\ControllerProvider();
$data = $provider->provide();
$data->display();



