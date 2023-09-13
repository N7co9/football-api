<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Redirect;
use App\Core\View;
use App\Model\UserEntityManager;
use App\Model\UserRepository;
use JetBrains\PhpStorm\NoReturn;

class LogoutController
{
    public function __construct
    (private readonly View              $_,
     private readonly UserEntityManager $__,
     private readonly UserRepository    $___,
     private readonly Redirect $redirect
    )

    {
    }

    public function dataConstruct(): object
    {
        session_start();
        session_destroy();
        $this->redirect->to('');
        return $this->redirect;
    }
}