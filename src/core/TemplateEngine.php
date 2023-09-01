<?php

namespace core;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class TemplateEngine
{
    public function render($template, $data)
    {
        $loader = new FilesystemLoader(__DIR__ . '/../view/template');
        $twig = new Environment($loader);
        echo $twig->render($template, $data);
    }
}