<?php

namespace Model;

use App\Model\DTO\UserDTO;
use App\Model\UserEntityManager;
use App\Model\UserMapper;
use App\Model\UserRepository;
use PHPUnit\Framework\TestCase;

class UserEntityManagerTest extends TestCase
{
    public UserMapper $userMapper;
    public UserEntityManager $entityManager;
    public UserRepository $userRepository;
    private string $testJsonPath = __DIR__ . '/../../src/Model/UserData.json';

    public function setUp(): void
    {
        $this->userMapper = new UserMapper();
        $this->entityManager = new UserEntityManager(new UserMapper($this->testJsonPath));
        $this->userRepository = new UserRepository();


        parent::setUp();
    }

    public function testSave(): void
    {
        $newUser = new UserDTO();
        $newUser->name = ('N4ME');
        $newUser->email = ('EMAIL');
        $newUser->passwort = ('PASSWORT');
        $newUser->favIDs = ["5", "4", "3"];

        $returnArray = $this->entityManager->save($newUser);

        foreach ($returnArray as $user) {
            $testEntry = array(
                "test-name" => $user->name,
                "test-email" => $user->email,
                "test-passwort" => $user->passwort,
                "fav-ids" => $user->favIDs
            );
        }
        self::assertSame($testEntry['test-name'], 'N4ME');
        self::assertSame($testEntry['test-email'], 'EMAIL');
        self::assertSame($testEntry['test-passwort'], 'PASSWORT');
        self::assertSame($testEntry['fav-ids'], ["5", "4", "3"]);
    }

    public function testAddFavSuccessful(): void
    {
        $favIdToAdd = "2";
        $_SESSION['mail'] = 'EMAIL';


        $newUser = new UserDTO();
        $newUser->name = ('N4ME');
        $newUser->email = ('EMAIL');
        $newUser->passwort = ('PASSWORT');
        $newUser->favIDs = ["5", "4", "3"];

        $this->entityManager->save($newUser);
        $this->entityManager->addFav($favIdToAdd);
        $favIDs = $this->userRepository->getFavIDs($_SESSION['mail']);

        self::assertSame('2', $favIDs[3]);
    }

    public function testRemFavSuccessful(): void
    {
        $favIdToRemove = "3";
        $_SESSION['mail'] = 'EMAIL';


        $newUser = new UserDTO();
        $newUser->name = ('N4ME');
        $newUser->email = ('EMAIL');
        $newUser->passwort = ('PASSWORT');
        $newUser->favIDs = ["5", "4", "3"];

        $this->entityManager->save($newUser);
        $this->entityManager->remFav($favIdToRemove);
        $favIDs = $this->userRepository->getFavIDs($_SESSION['mail']);

        self::assertCount(2, $favIDs);

        self::assertArrayHasKey(0, $favIDs);
        self::assertArrayHasKey(1, $favIDs);
    }

    public function testManageFavSuccessful(): void
    {
        $favIDsToManage = ["100", "200", "300", "400", "500"];
        $_SESSION['mail'] = 'EMAIL';


        $newUser = new UserDTO();
        $newUser->name = ('N4ME');
        $newUser->email = ('EMAIL');
        $newUser->passwort = ('PASSWORT');
        $newUser->favIDs = ["5", "4", "3"];

        $this->entityManager->save($newUser);
        $this->entityManager->manageFav($favIDsToManage);
        $favIDs = $this->userRepository->getFavIDs($_SESSION['mail']);

        self::assertCount(5, $favIDs);
        self::assertSame('100', $favIDs[0]);
        self::assertSame('500', $favIDs[4]);
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