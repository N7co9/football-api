<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Container;
use App\Core\Redirect;
use App\Core\View;

class LogoutController implements ControllerInterface
{
    public function __construct(private readonly Container $container)
    {
        $this->redirect = $this->container->get(Redirect::class);
    }

    public function dataConstruct() : void
    {
        session_start();
        session_destroy();
        $this->redirect->to('');
    }
}