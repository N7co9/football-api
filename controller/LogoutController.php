<?php
declare(strict_types=1);
namespace MyProject;

class LogoutController implements ControllerInterface
{
    public function dataConstruct()
    {
        session_start();
        session_destroy();
        header('Location: /../index.php');
        exit;
    }
}