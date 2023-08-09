<?php
declare(strict_types=1);

use Twig\Loader\FilesystemLoader;
use Twig\Environment;


$loader = new FilesystemLoader(__DIR__ . '/template');
$twig = new Environment($loader);

echo $twig->render('login.twig', []);
