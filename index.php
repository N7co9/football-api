<?php
declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";

require_once '/home/nicogruenewald/Documents/football-api/partials/header.php';
require_once '/home/nicogruenewald/Documents/football-api/partials/footer.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require '/home/nicogruenewald/Documents/football-api/routing.php';


