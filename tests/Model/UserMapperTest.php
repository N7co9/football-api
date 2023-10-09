<?php

namespace Model;

use App\Model\DTO\UserDTO;
use App\Model\SQL\SqlConnector;
use App\Model\UserMapper;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\fileExists;

class UserMapperTest extends TestCase
{
    private UserMapper $userMapper;

    public function setUp(): void
    {
        $this->userMapper = new UserMapper();
    }

    public function testMapFromArray2Dto(): void
    {
        $array = array(
            [
                "id" => "1",
                "name" => "TEST",
                "email" => "TEST@TEST.COM",
                "password" => "qwertz",
                "fav-ids" => [
                    "0" => "1",
                    "1" => "2"
                ]
            ]
        );

        $user = $this->userMapper->mapFromArray2Dto($array);

        self::assertSame('TEST', $user->name);
        self::assertSame(["0" => "1", "1" => "2"], $user->favIDs);
    }

    public function testMapFromDto2Array(): void
    {
        $user = new UserDTO();
        $user->id = 1;
        $user->name = "TEST";
        $user->email = "TEST@TEST.COM";
        $user->passwort = "qwertz";
        $user->favIDs = ["0" => "1", "1" => "2"];

        $array = $this->userMapper->mapFromDto2Array($user);

        self::assertSame(1, $array['id']);
        self::assertSame('TEST@TEST.COM', $array['email']);
        self::assertSame(["0" => "1", "1" => "2"], $array['fav-ids'][0]);
    }

    public function tearDown(): void
    {
        $connector = new SqlConnector();
        $connector->executeDeleteQuery("DELETE FROM user_favorites;", []);
        $connector->executeDeleteQuery("DELETE FROM users;", []);
        $connector->closeConnection();
        parent::tearDown();
        parent::tearDown();
    }
}
