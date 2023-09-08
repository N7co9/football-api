<?php

namespace App\Core;

use mysql_xdevapi\SqlStatementResult;
use PHPUnit\TextUI\Configuration\File;
use PHPUnit\Util\Xml\Loader;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class View implements ViewInterface
{
    private Environment $twig;
    private string $tpl;

    public function __construct(string $templatePath)
    {
        $loader = new FilesystemLoader($templatePath);
        $this->twig = new Environment($loader);
    }

    public function addParameter(string $key, mixed $value): void
    {
        $this->parameters[$key] = $value;
    }

    public function display()
    {
        echo $this->twig->render($this->tpl, $this->parameters);
    }

    public function setTemplate(string $tpl) {
        $this->tpl = $tpl;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }
    public function getTpl() : string
    {
        return $this->tpl;
    }
}