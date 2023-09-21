<?php

namespace App\Controller;

use App\Core\Api\ApiHandling;
use App\Core\Api\ApiMapper;
use App\Core\Container;
use App\Core\FavoritesLogic\FavManipulation;
use App\Core\FavoritesLogic\FavMapper;
use App\Core\Redirect;
use App\Core\View;
use App\Model\UserEntityManager;
use App\Model\UserRepository;

class FavoriteController implements ControllerInterface
{
    public Redirect $redirect;
    public UserEntityManager $userEntityManager;
    public View $templateEngine;
    public ApiMapper $ApiMapper;
    public UserRepository $userRepository;
    public FavManipulation $favManipulation;

    public function __construct(Container $container)
    {
        $this->redirect = $container->get(Redirect::class);
        $this->userEntityManager = $container->get(UserEntityManager::class);
        $this->templateEngine = $container->get(View::class);
        $this->ApiMapper = $container->get(ApiMapper::class);
        $this->userRepository = $container->get(UserRepository::class);
        $this->favManipulation = $container->get(FavManipulation::class);
    }

    public function dataConstruct(): View
    {
        $handling = new ApiHandling($this->ApiMapper);
        $mapper = new FavMapper($this->userRepository, $handling);
        $listOfFavDTOs = $mapper->mapDTO();

        $action = (string)$_GET['action'];
        $id = $_GET['id'] ?? '';

        $this->addFavoriteTeam($action, $id);

        $this->moveFavoriteTeamUp($action, $id);

        $this->removeFavoriteTeam($action, $id);

        $this->moveFavoriteTeamDown($action, $id);

        if (!empty($_SESSION['mail'])) {
            $this->templateEngine->addParameter('user', $_SESSION['mail']);
            $this->templateEngine->addParameter('favorites', $listOfFavDTOs);
            $this->templateEngine->setTemplate('favorites.twig');
            return $this->templateEngine;
        }
        return $this->templateEngine;
    }

    private function addFavoriteTeam(string $action, mixed $id): void
    {
        if ($action === 'add' && !empty($_SESSION['mail'])) {
            $this->userEntityManager->addFav($id);
        }
    }

    public function removeFavoriteTeam(string $action, mixed $id): void
    {
        if ($action === 'remove' && !empty($_SESSION['mail'])) {
            $this->userEntityManager->remFav($id);
            header("Location: " . '/index.php?page=favorites&action=manage');
        }
    }

    public function moveFavoriteTeamDown(string $action, string $id): void
    {
        if ($action === 'down' && !empty($_SESSION['mail'])) {
            $newFavIDs = $this->favManipulation->moveNumberDown($this->userRepository->getFavIDs($_SESSION['mail']), $id);
            $this->userEntityManager->manageFav($newFavIDs);
            header("Location: " . '/index.php?page=favorites&action=manage');
        }
    }

    public function moveFavoriteTeamUp(string $action, string $id): void
    {
        if ($action === 'up' && !empty($_SESSION['mail'])) {
            $newFavIDs = $this->favManipulation->moveNumberUp($this->userRepository->getFavIDs($_SESSION['mail']), $id);
            $this->userEntityManager->manageFav($newFavIDs);
            header("Location: " . '/index.php?page=favorites&action=manage');
        }
    }
}