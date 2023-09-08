<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\ControllerMapper;
use App\Core\Redirect;
use App\Core\View;
use JsonException;
use App\Model\UserEntityManager;
use App\Model\UserMapper;
use App\Model\UserRepository;

class ControllerProvider
{
    /**
     * @throws JsonException
     */
    public function provide()
    {

        $mapDTO = new ControllerMapper();
        $array = $mapDTO->JsonToDTO();
        $query = $_GET['page'] ?? '';

        $template = new View(__DIR__ . '/../View/template');
        $userManager = new UserEntityManager(new UserMapper(__DIR__ . '/../../src/Model/UserData.json'));
        $userRepository = new UserRepository();
        $redirect = new Redirect();

        foreach ($array as $item) {
            if ($query === $item->getQuery()) {
                $controller = $item->getController();
                $controllerCall = new $controller($template, $userManager, $userRepository, $redirect);
                return $controllerCall->dataConstruct();
            }
        }
        return $template;
    }
}
