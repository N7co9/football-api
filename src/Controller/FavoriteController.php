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
use JsonException;

class FavoriteController implements ControllerInterface
{
    public Redirect $redirect;
    public UserEntityManager $userEntityManager;
    public View $templateEngine;
    public ApiMapper $ApiMapper;
    public UserRepository $userRepository;
    public FavManipulation $favManipulation;
    public string $actionMap;

    public function __construct(Container $container)
    {
        $this->redirect = $container->get(Redirect::class);
        $this->userEntityManager = $container->get(UserEntityManager::class);
        $this->templateEngine = $container->get(View::class);
        $this->ApiMapper = $container->get(ApiMapper::class);
        $this->userRepository = $container->get(UserRepository::class);
        $this->favManipulation = $container->get(FavManipulation::class);
    }

    /**
     * @throws JsonException
     */
    public function dataConstruct(): View
    {
        $handling = new ApiHandling($this->ApiMapper);
        $mapper = new FavMapper($this->userRepository, $handling);
        $listOfFavDTOs = $mapper->mapDTO();

        $action = $_GET['action'] ?? '';
        $id = $_GET['id'] ?? '';

        $actionMap = [
            'add' => 'addFavoriteTeam',
            'remove' => 'removeFavoriteTeam',
            'down' => 'moveFavoriteTeamDown',
            'up' => 'moveFavoriteTeamUp',
        ];

        if (!empty($_SESSION['mail']) && array_key_exists($action, $actionMap)) {
            $this->{$actionMap[$action]}($action, $id);
            $this->actionMap = 'valid';
        } else
        {
            $this->actionMap = 'invalid-action';
        }


        $this->userRepository->checkIfFavIdAlreadyAdded($_SESSION['mail'], $id);

        if (!empty($_SESSION['mail'])) {
            $this->templateEngine->addParameter('user', $_SESSION['mail']);
            $this->templateEngine->addParameter('favorites', $listOfFavDTOs);
            $this->templateEngine->setTemplate('favorites.twig');
            return $this->templateEngine;
        }
        return $this->templateEngine;
    }

    /**
     * @throws JsonException
     */
    public function addFavoriteTeam(string $action, mixed $id): void
    {
            $this->userEntityManager->addFav($id);
            $this->redirect->to('');
    }

    /**
     * @throws JsonException
     */
    public function removeFavoriteTeam(string $action, mixed $id): void
    {
            $this->userEntityManager->remFav($id);
            $this->redirect->to('');
    }

    /**
     * @throws JsonException
     */
    public function moveFavoriteTeamDown(string $action, string $id): void
    {
            $newFavIDs = $this->favManipulation->moveNumberDown($this->userRepository->getFavIDs($_SESSION['mail']), $id);
            $this->userEntityManager->manageFav($newFavIDs);
            $this->redirect->to('index.php?page=favorites&action=manage');
    }

    /**
     * @throws JsonException
     */
    public function moveFavoriteTeamUp(string $action, string $id): void
    {
            $newFavIDs = $this->favManipulation->moveNumberUp($this->userRepository->getFavIDs($_SESSION['mail']), $id);
            $this->userEntityManager->manageFav($newFavIDs);
            $this->redirect->to('index.php?page=favorites&action=manage');
    }
}