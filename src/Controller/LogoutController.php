<?php
declare(strict_types=1);

namespace App\Controller;

use JetBrains\PhpStorm\NoReturn;

class LogoutController implements ControllerInterface
{
    #[NoReturn] public function dataConstruct(): void
    {
        session_start();
        session_destroy();
        header('Location: /../index.php');
        exit;
    }
}