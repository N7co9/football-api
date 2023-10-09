<?php

namespace Core\FavoritesLogic;

use App\Core\Api\ApiHandling;
use App\Core\Api\ApiMapper;
use App\Core\FavoritesLogic\FavMapper;
use App\Model\DTO\UserDTO;
use App\Model\SQL\SqlConnector;
use App\Model\UserEntityManager;
use App\Model\UserMapper;
use App\Model\UserRepository;
use PHPUnit\Framework\TestCase;

class FavMapperTest extends TestCase
{
    public UserRepository $userRepository;
    public ApiHandling $apiHandling;

    public function setUp(): void
    {
        $this->userRepository = new UserRepository();
        $this->apiHandling = new ApiHandling(new ApiMapper());
        $this->entityManager = new UserEntityManager(new UserMapper());


        $this->newUser = new UserDTO();
        $this->newUser->name = ('TEST');
        $this->newUser->email = ('TESTz@zTEST.COM');
        $this->newUser->passwort = ('$2y$10$hGVJpxSAGmoys3hfECyDh.bLHrw/hzRXoj3ZTHB6h0Pj46TA52adu');

        $_SESSION['mail'] = $this->newUser->email;


        parent::setUp();
    }

    public function testMapDTOSuccessful() : void
    {
        $this->entityManager->saveCredentials($this->newUser);
        $id = $this->userRepository->getUserID($this->newUser->email);
        $this->entityManager->addFav("3", $id);

        $mapper = new FavMapper($this->userRepository, $this->apiHandling);
        $listOfFavDTOs = $mapper->mapFavIDtoDTO();

        self::assertIsArray($listOfFavDTOs);
        self::assertIsObject($listOfFavDTOs[0]);
        self::assertSame('3', $listOfFavDTOs[0]->id);
        self::assertSame('Bayer 04 Leverkusen', $listOfFavDTOs[0]->name);
    }

    public function testMapDTONoFavTeamAssigned() : void
    {
        $_SESSION['mail'] = '';     // empty input ensures there will be no team assigned to a non existing user.
        $mapper = new FavMapper($this->userRepository, $this->apiHandling);
        $listOfFavDTOs = $mapper->mapFavIDtoDTO();

        self::assertNull($listOfFavDTOs);
    }
    public function tearDown(): void
    {
        $connector = new SqlConnector();
        $connector->executeDeleteQuery("DELETE FROM user_favorites;", []);
        $connector->executeDeleteQuery("DELETE FROM users;", []);
        parent::tearDown();
    }

}