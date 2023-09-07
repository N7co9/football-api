<?php

namespace ModelTest;

use DTO\UserDTO;
use model\UserMapper;
use PHPUnit\Framework\TestCase;

class UserMapperTest extends TestCase
{
    private UserMapper $userMapper;
    private string $testJsonPath = __DIR__ . '/../AppTest/UserData.json';

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
                'password' => '3',
            ],
            [
                'name' => '',
                'email' => '',
                'password' => ''
            ]
        );

        file_put_contents($this->testJsonPath, json_encode($testJsonData, JSON_PRETTY_PRINT));

        $userDTOList = $this->userMapper->JsonToDTO();

        $this->assertIsArray($userDTOList);
        $this->assertContainsOnlyInstancesOf(UserDTO::class, $userDTOList);
        $this->assertSame($userDTOList[0]->getName(), '1');
        $this->assertSame($userDTOList[0]->getEmail(), '2');
        $this->assertSame($userDTOList[0]->getPassword(), '3');
    }

    public function testDTO2Json(): void
    {
        $userDTOList = [];

        $userDTO1 = new UserDTO();
        $userDTO1->setName('User 1 Name');
        $userDTO1->setEmail('user1@example.com');
        $userDTO1->setPassword('password1');
        $userDTOList[] = $userDTO1;

        $userDTO2 = new UserDTO();
        $userDTO2->setName('User 2 Name');
        $userDTO2->setEmail('user2@example.com');
        $userDTO2->setPassword('password2');
        $userDTOList[] = $userDTO2;

        $this->userMapper->DTO2Json($userDTOList);

        $jsonContent = file_get_contents($this->testJsonPath);

        $decodedData = json_decode($jsonContent, true);

        $this->assertIsArray($decodedData);
        $this->assertCount(count($userDTOList), $decodedData);
    }
}
