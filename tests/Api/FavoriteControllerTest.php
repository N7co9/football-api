<?php

namespace Api;

use App\Controller\FavoriteController;
use App\Core\Api\ApiMapper;
use App\Core\Container;
use App\Core\DependencyProvider;
use App\Core\FavoritesLogic\FavManipulation;
use App\Core\Redirect;
use App\Core\View;
use App\Model\DTO\UserDTO;
use App\Model\UserEntityManager;
use App\Model\UserRepository;
use PHPUnit\Framework\TestCase;
use ReflectionObject;
use Twig\Loader\FilesystemLoader;

class FavoriteControllerTest extends TestCase
{
    public Redirect $redirect;
    public UserEntityManager $userEntityManager;
    public View $templateEngine;
    public ApiMapper $ApiMapper;
    public UserRepository $userRepository;
    public FavManipulation $favManipulation;

    protected function setUp(): void
    {
        $containerBuilder = new Container();
        $dependencyProvider = new DependencyProvider();
        $dependencyProvider->provide($containerBuilder);
        $this->container = $containerBuilder;
        $this->construct = new FavoriteController($this->container);

        $this->redirect = $this->container->get(Redirect::class);
        $this->userEntityManager = $this->container->get(UserEntityManager::class);
        $this->templateEngine = $this->container->get(View::class);
        $this->ApiMapper = $this->container->get(ApiMapper::class);
        $this->userRepository = $this->container->get(UserRepository::class);
        $this->favManipulation = $this->container->get(FavManipulation::class);

        parent::setUp();
    }

    public function testDataConstruct(): void
    {
        $_SESSION['mail'] = 'not-empty';
        $output = $this->construct->dataConstruct();
        self::assertSame('favorites.twig', $output->getTpl());
        self::assertSame('not-empty', $output->getParameters()['user']);
    }

    public function testAddFavoriteTeam(): void
    {
        $newUser = new UserDTO();
        $newUser->name = ('N4ME');
        $newUser->email = ('EMAIL');
        $newUser->passwort = ('PASSWORT');
        $newUser->favIDs = ["5", "4", "3"];

        $this->userEntityManager->saveCredentials($newUser);

        $action = 'add';
        $_SESSION['mail'] = 'EMAIL';

        $idToRemove = '2';

        $this->construct->addFavoriteTeam($action, $idToRemove);

        self::assertSame('2', $this->userRepository->getFavIDs('EMAIL')[3]);
        self::assertCount(4, $this->userRepository->getFavIDs('EMAIL'));
    }

    public function testMoveFavoriteTeamDown(): void
    {
        $newUser = new UserDTO();
        $newUser->name = ('N4ME');
        $newUser->email = ('EMAIL');
        $newUser->passwort = ('PASSWORT');
        $newUser->favIDs = ["5", "4", "3"];

        $this->userEntityManager->saveCredentials($newUser);

        $action = 'down';
        $_SESSION['mail'] = 'EMAIL';

        $idToMove = '4';

        $this->construct->moveFavoriteTeamDown($action, $idToMove);

        self::assertSame('4', $this->userRepository->getFavIDs('EMAIL')[2]);
        self::assertCount(3, $this->userRepository->getFavIDs('EMAIL'));
    }

    public function testMoveFavoriteTeamUp(): void
    {
        $newUser = new UserDTO();
        $newUser->name = ('N4ME');
        $newUser->email = ('EMAIL');
        $newUser->passwort = ('PASSWORT');
        $newUser->favIDs = ["5", "4", "3"];

        $this->userEntityManager->saveCredentials($newUser);

        $action = 'down';
        $_SESSION['mail'] = 'EMAIL';

        $idToMove = '4';

        $this->construct->moveFavoriteTeamUp($action, $idToMove);

        self::assertSame('4', $this->userRepository->getFavIDs('EMAIL')[0]);
        self::assertCount(3, $this->userRepository->getFavIDs('EMAIL'));
    }

    public function testRemoveFavoriteTeam(): void
    {
        $newUser = new UserDTO();
        $newUser->name = ('N4ME');
        $newUser->email = ('EMAIL');
        $newUser->passwort = ('PASSWORT');
        $newUser->favIDs = ["5", "4", "3"];

        $this->userEntityManager->saveCredentials($newUser);

        $action = 'down';
        $_SESSION['mail'] = 'EMAIL';

        $idToMove = '4';

        $this->construct->removeFavoriteTeam($action, $idToMove);

        self::assertSame('5', $this->userRepository->getFavIDs('EMAIL')[0]);
        self::assertSame('3', $this->userRepository->getFavIDs('EMAIL')[1]);
        self::assertCount(2, $this->userRepository->getFavIDs('EMAIL'));
    }

    public function testEmptyMail(): void
    {
        $_SESSION['mail'] = '';

        $output = $this->construct->dataConstruct();

        self::assertInstanceOf(View::class, $output);
    }

    public function testActionMapValid()
    {
        $_SESSION['mail'] = 'not-empty';
        $_GET['action'] = 'add';

        $this->construct->dataConstruct();
        $actionMapOutput = $this->construct->actionMap;

        self::assertSame('valid', $actionMapOutput);
    }
    public function testActionMapInvalid()
    {
        $_SESSION['mail'] = 'not-empty';
        $_GET['action'] = 'invalid-action';

        $this->construct->dataConstruct();
        $actionMapOutput = $this->construct->actionMap;

        self::assertSame('invalid-action', $actionMapOutput);
    }

    public function tearDown(): void
    {

        $getContents = file_get_contents(__DIR__ . '/../../src/Model/UserData.json',);
        $arrayFromJSON = json_decode($getContents, true);

        if (!empty($arrayFromJSON)) {
            $count = count($arrayFromJSON) - 1;
        }

        if (($arrayFromJSON[$count ?? null]['name']) === 'N4ME') {
            array_pop($arrayFromJSON);
            $encoded = json_encode($arrayFromJSON, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
            file_put_contents(__DIR__ . '/../../src/Model/UserData.json', $encoded);
        }
        parent::tearDown();
    }
}