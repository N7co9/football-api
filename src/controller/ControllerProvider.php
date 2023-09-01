<?php
declare(strict_types=1);

namespace MyProject;

use core\View;
use JsonException;
use model\UserEntityManager;
use model\UserRepository;

class ControllerProvider
{
    /**
     * @throws JsonException
     */
    public function provide(): void
    {
        $array = json_decode(file_get_contents(__DIR__ . '/../model/Routes.json'), true, 512, JSON_THROW_ON_ERROR);
        $request = $_SERVER['REQUEST_URI'] ?? null;
        $query = $_GET['page'] ?? null;

        $template = new View(__DIR__ . '/../view/template');
        $userManager = new UserEntityManager(__DIR__ . '/../model/UserData.json');
        $userRepository = new UserRepository();

        foreach ($array as $item) {
            if ($request === $item['url'] || $query === $item['query']) {
                $controller = new $item['controller']($template, $userManager, $userRepository);
                $controller->dataConstruct();
            }
        }
    }
}
