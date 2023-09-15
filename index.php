<?php
declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";

session_start();                                        // ERROR HANDLING
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


$container = new \App\Core\Container();
$dependencyProvider = new \App\Core\DependencyProvider();
$dependencyProvider->provide($container);
$provider = new \App\Core\ControllerProvider();
$page = $_GET['page'] ?? '';


foreach ($provider->getList() as $key => $controllerClass) {
    if ($key === $page) {
        $controllerCheck = new $controllerClass($container);
        if ($controllerCheck instanceof \App\Controller\ControllerInterface) {
            $controller = $controllerCheck;
            break;
        }
    }
}

$data = $controller->dataConstruct();
$data->display();
