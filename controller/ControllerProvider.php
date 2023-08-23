<?php
declare(strict_types=1);

namespace MyProject;

use JsonException;
use model\UserEntityManager;
use model\UserRepository;
use vendor\TemplateEngine;

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

        $template = new TemplateEngine();
        $userManager = new UserEntityManager();
        $userRepository = new UserRepository();

        foreach ($array as $item) {
            if ($request === $item['url'] || $query === $item['query']) {
                $controller = new $item['controller']($template, $userManager, $userRepository);
                $controller->dataConstruct();
            }
        }
    }
}
