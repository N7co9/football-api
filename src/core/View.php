<?php

namespace core;

use PHPUnit\TextUI\Configuration\File;
use PHPUnit\Util\Xml\Loader;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class View implements ViewInterface
{
    private $twig;

    public function __construct(string $templatePath)
    {
        $loader = new FilesystemLoader($templatePath);
        $this->twig = new Environment($loader);
    }

    public function addParameter($key, $value): void
    {
        $this->parameters[$key] = $value;
    }

    public function display(string $template)
    {
        $parameters = array_merge($this->parameters);
        echo $this->twig->render($template, $parameters);
    }
}