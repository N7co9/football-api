<?php

namespace Model;

use App\Model\DTO\UserDTO;
use App\Model\UserMapper;
use PHPUnit\Framework\TestCase;

class UserMapperTest extends TestCase
{
    private UserMapper $userMapper;
    private string $testJsonPath = __DIR__ . '/../Model/UserData.json';

    public function setUp(): void
    {
        $this->userMapper = new UserMapper($this->testJsonPath);

    }

    public function testJson2DTO(): void
    {
        $testJsonData = array(
            [
                'name' => '1',
                'email' => '2',
                'passwort' => '3',
                'fav-ids' => ["5"]
            ],
            [
                'name' => '',
                'email' => '',
                'passwort' => '',
                'fav-ids' => []
            ]
        );

        file_put_contents($this->testJsonPath, json_encode($testJsonData, JSON_PRETTY_PRINT));

        $userDTOList = $this->userMapper->JsonToDTO();

        $this->assertIsArray($userDTOList);
        $this->assertContainsOnlyInstancesOf(UserDTO::class, $userDTOList);
        $this->assertSame($userDTOList[0]->name, '1');
        $this->assertSame($userDTOList[0]->email, '2');
        $this->assertSame($userDTOList[0]->passwort, '3');
        $this->assertSame($userDTOList[0]->favIDs, ["0" => "5"]);
    }

    public function testDTO2Json(): void
    {
        $userDTOList = [];

        $userDTO1 = new UserDTO();
        $userDTO1->name = ('User 1 Name');
        $userDTO1->email = ('user1@example.com');
        $userDTO1->passwort = ('passwort1');
        $userDTO1->favIDs = ["5"];
        $userDTOList[] = $userDTO1;

        $userDTO2 = new UserDTO();
        $userDTO2->name = ('User 2 Name');
        $userDTO2->email = ('user2@example.com');
        $userDTO2->passwort = ('passwort2');
        $userDTO2->favIDs = ["5"];
        $userDTOList[] = $userDTO2;

        $this->userMapper->DTO2Json($userDTOList);

        $jsonContent = file_get_contents($this->testJsonPath);

        $decodedData = json_decode($jsonContent, true);

        $this->assertIsArray($decodedData);
        $this->assertCount(count($userDTOList), $decodedData);
    }
}
