<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Api\ApiHandling;
use App\Core\Api\ApiMapper;
use App\Core\Container;
use App\Core\FavoritesProvider;
use App\Core\View;
use App\Model\DTO\FavoriteDTO;
use App\Model\DTO\UserDTO;
use App\Model\UserRepository;

class HomeController implements ControllerInterface
{
    private View $templateEngine;
    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(View::class);
        $this->ApiMapper = $container->get(ApiMapper::class);
        $this->userRepository = $container->get(UserRepository::class);
    }

    public function dataConstruct(): View
    {
        $apiHandler = new ApiHandling($this->ApiMapper);
        $result = $apiHandler->getCompetitions();

        $provider = new FavoritesProvider($this->userRepository, $apiHandler);
        $listOfFavDTOs = $provider->provide();

        $this->templateEngine->setTemplate('home.twig');
        $this->templateEngine->addParameter('favorites', $listOfFavDTOs);
        $this->templateEngine->addParameter('competitions', $result);
        $this->templateEngine->addParameter('user', $_SESSION['mail'] ?? null);

        return $this->templateEngine;
    }
}
