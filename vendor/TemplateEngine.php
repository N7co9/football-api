<?php

namespace vendor;

class TemplateEngine
{
    public function render($template, $data)
    {
        $twig = initTwig();
        echo $twig->render($template, $data);
    }
}