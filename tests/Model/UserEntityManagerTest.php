<?php

namespace Model;

use App\Controller\FavoriteController;
use App\Model\DTO\UserDTO;
use App\Model\SQL\SqlConnector;
use App\Model\UserEntityManager;
use App\Model\UserMapper;
use App\Model\UserRepository;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

class UserEntityManagerTest extends TestCase
{
    public UserMapper $userMapper;
    public UserEntityManager $entityManager;
    public UserRepository $userRepository;
    public UserDTO $newUser;
    public SqlConnector $sqlConnector;

    public function setUp(): void
    {
        $this->userMapper = new UserMapper();
        $this->entityManager = new UserEntityManager(new UserMapper());
        $this->userRepository = new UserRepository();
        $this->sqlConnector = new SqlConnector();

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
        $favIDs = $this->userRepository->getFavIDs($_SESSION['mail']);

        self::assertContains('1', $favIDs);
    }

    public function testRemFavSuccessful(): void
    {
        $_SESSION['mail'] = $this->newUser->email;
        $favIDs = $this->userRepository->getFavIDs($_SESSION['mail']); // get Favs

        self::assertNull($favIDs);
    }

    public function tearDown(): void
    {
        $connector = new SqlConnector();
        $connector->executeDeleteQuery("DELETE FROM users;", []);
        $this->sqlConnector->closeConnection();
        parent::tearDown();
    }
}