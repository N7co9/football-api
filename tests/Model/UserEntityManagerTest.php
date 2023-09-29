<?php

namespace Model;

use App\Core\FavoritesLogic\FavManipulator;
use App\Model\DTO\UserDTO;
use App\Model\SQL\SqlConnector;
use App\Model\UserEntityManager;
use App\Model\UserMapper;
use App\Model\UserRepository;
use PDOException;
use PHPUnit\Framework\TestCase;

class UserEntityManagerTest extends TestCase
{
    public UserMapper $userMapper;
    public UserEntityManager $entityManager;
    public UserRepository $userRepository;
    public UserDTO $newUser;
    public SqlConnector $sqlConnector;
    public FavManipulator $manipulator;

    public function setUp(): void
    {
        $this->userMapper = new UserMapper();
        $this->entityManager = new UserEntityManager(new UserMapper());
        $this->userRepository = new UserRepository();
        $this->sqlConnector = new SqlConnector();
        $this->manipulator = new FavManipulator();

        $this->newUser = new UserDTO();
        $this->newUser->name = ('TEST');
        $this->newUser->email = ('TESTz@zTEST.COM');
        $this->newUser->passwort = ('qwertz');

        parent::setUp();
    }

    public function testSaveCredentials(): void
    {
        $this->entityManager->saveCredentials($this->newUser);

        $user = $this->userRepository->findByMail('TESTz@zTEST.COM');
        self::assertSame('TEST', $user->name);
        self::assertSame('qwertz', $user->passwort);
    }

    public function testAddFavSuccessful(): void
    {
        $this->entityManager->saveCredentials($this->newUser);

        $favIdToAdd = "1";

        $_SESSION['mail'] = $this->newUser->email;
        $id = $this->userRepository->getUserID($this->newUser->email);
        $this->entityManager->addFav($favIdToAdd, $id);
        $favIDs = $this->userRepository->getFavIDs($this->userRepository->getUserID($_SESSION['mail']));

        self::assertContains('1', $favIDs);
    }

    public function testRemFavSuccessful(): void
    {
        $this->entityManager->saveCredentials($this->newUser);
        $_SESSION['mail'] = $this->newUser->email;
        $id = $this->userRepository->getUserID($_SESSION['mail']);
        $this->entityManager->addFav("1", $id);
        $_SESSION['mail'] = $this->newUser->email;

        $this->entityManager->remFav("1", $id);

        $favIDs = $this->userRepository->getFavIDs($this->userRepository->getUserID($_SESSION['mail']));

        self::assertNull($favIDs);
    }

    public function testSaveManipulatedOrderUp() : void
    {
        $this->entityManager->saveCredentials($this->newUser);
        $_SESSION['mail'] = $this->newUser->email;
        $id = $this->userRepository->getUserID($_SESSION['mail']);
        $this->entityManager->addFav("1", $id);
        $this->entityManager->addFav("2", $id);
        $_SESSION['mail'] = $this->newUser->email;

        $manipulatedArray = $this->manipulator->moveTeamOnePlaceUp($id, '2');
        $this->entityManager->saveManipulatedOrder($manipulatedArray, $id);

        $favids = $this->userRepository->getFavIDs($id);

        self::assertSame('2', $favids[0]);
        self::assertSame('1', $favids[1]);
    }

    public function testSaveManipulatedOrderDown() : void
    {
        $this->entityManager->saveCredentials($this->newUser);
        $_SESSION['mail'] = $this->newUser->email;
        $id = $this->userRepository->getUserID($_SESSION['mail']);
        $this->entityManager->addFav("1", $id);
        $this->entityManager->addFav("2", $id);
        $_SESSION['mail'] = $this->newUser->email;

        $manipulatedArray = $this->manipulator->moveTeamOnePlaceDown($id, '1');
        $this->entityManager->saveManipulatedOrder($manipulatedArray, $id);

        $favids = $this->userRepository->getFavIDs($id);

        self::assertSame('2', $favids[0]);
        self::assertSame('1', $favids[1]);
    }

    public function tearDown(): void
    {
        $connector = new SqlConnector();
        $connector->executeDeleteQuery("DELETE FROM users;", []);
        $this->sqlConnector->closeConnection();
        parent::tearDown();
    }
}