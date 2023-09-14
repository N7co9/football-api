<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Container;
use App\Core\Redirect;

class LogoutController implements ControllerInterface
{
    private Redirect $redirect;

    public function __construct(Container $container)
    {
        $this->redirect = $container->get(Redirect::class);
    }

    public function dataConstruct(): void
    {
        session_start();
        session_destroy();
        $this->redirect->to('');
    }
}