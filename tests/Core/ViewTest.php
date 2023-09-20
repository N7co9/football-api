<?php

namespace Core;

use App\Core\View;
use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
    public function testDisplay()
    {
        $templatePath = __DIR__ . '/../testData/';
        $view = new View($templatePath);
        $view->setTemplate('test.twig');
        $view->addParameter('name', 'Nico');

        ob_start();
        $view->display();
        $output = ob_get_clean();

        $this->assertStringContainsString('Hi, Nico', $output);
    }

}