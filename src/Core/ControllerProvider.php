<?php
declare(strict_types=1);

namespace App\Core;

use App\Controller\ClubController;
use App\Controller\HomeController;
use App\Controller\LogoutController;
use App\Controller\PlayerController;
use App\Controller\RegistrationController;
use App\Controller\SessionController;
use App\Controller\TeamController;

class ControllerProvider
{
    public function getList(): array
    {
        return [

            "" => HomeController::class,

            "competition" => TeamController::class,

            "team" => ClubController::class,

            "player" => PlayerController::class,

            "registration" => RegistrationController::class,

            "logout" => LogoutController::class,

            "login" => SessionController::class

        ];
    }
}
