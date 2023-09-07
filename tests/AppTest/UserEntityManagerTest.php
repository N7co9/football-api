<?php

namespace AppTest;

use DTO\UserDTO;
use model\UserEntityManager;
use model\UserMapper;
use PHPUnit\Framework\TestCase;

class UserEntityManagerTest extends TestCase
{
    private string $testJsonPath = __DIR__ . '/../AppTest/UserData.json';
    public function testSave(): void
    {
        $newUser = new UserDTO();
        $newUser->setName('NAME');
        $newUser->setEmail('EMAIL');
        $newUser->setPassword('PASSWORD');

        $em = new UserEntityManager(new UserMapper($this->testJsonPath));
        $returnArray = $em->save($newUser);

        foreach ($returnArray as $user) {
            $testEntry = array(
                "test-name" => $user->getName(),
                "test-email" => $user->getEmail(),
                "test-password" => $user->getPassword()
            );
        }
        self::assertSame($testEntry['test-name'], 'NAME');
        self::assertSame($testEntry['test-email'], 'EMAIL');
        self::assertSame($testEntry['test-password'], 'PASSWORD');
    }
}