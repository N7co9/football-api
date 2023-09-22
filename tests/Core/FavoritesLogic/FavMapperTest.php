<?php

namespace Core\FavoritesLogic;

use App\Core\Api\ApiHandling;
use App\Core\Api\ApiMapper;
use App\Core\FavoritesLogic\FavMapper;
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
        parent::setUp();
    }

    public function testMapDTOSuccessful() : void
    {
        $_SESSION['mail'] = 'validation@validation.com';
        $mapper = new FavMapper($this->userRepository, $this->apiHandling);
        $listOfFavDTOs = $mapper->mapDTO();

        self::assertIsArray($listOfFavDTOs);
        self::assertIsObject($listOfFavDTOs[0]);
        self::assertSame('3', $listOfFavDTOs[0]->id);
        self::assertSame('Bayer 04 Leverkusen', $listOfFavDTOs[0]->name);
    }

    public function testMapDTONoFavTeamAssigned() : void
    {
        $_SESSION['mail'] = '';     // empty input ensures there will be no team assigned to a non existing user.
        $mapper = new FavMapper($this->userRepository, $this->apiHandling);
        $listOfFavDTOs = $mapper->mapDTO();

        self::assertNull($listOfFavDTOs);
    }
    public function tearDown(): void
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
    }

}