<?php

namespace AppTest;

use JsonException;
use model\UserRepository;
use PHPUnit\Framework\TestCase;
use model\UserEntityManager;

class UserEntityManagerTest extends TestCase
{
    private string $testData = __DIR__ . '/../testData/testUser.json';

    /**
     * @throws JsonException
     */
    public function tearDown(): void // deletes the dir after creating one in case its fresh
    {
        parent::tearDown();
        if (file_exists($this->testData)) {
            unlink($this->testData);
        }

        $importJSON = json_decode(file_get_contents(__DIR__ . '/../../src/model/UserData.json'), true, 512, JSON_THROW_ON_ERROR); // removes the 'test' entry in our userdata from testing
        foreach ($importJSON as $subKey => $subArray) {
            if ($subArray['test'] === 'successful') {
                unset($importJSON[$subKey]);
            }
        }
        file_put_contents(__DIR__ . '/../../src/model/UserData.json', json_encode($importJSON, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));
    }

    /**
     * @throws JsonException
     */
    public function testSave(): void // happy case testing -> dir exists
    {
        $mockArray = array(
            'test' => 'successful');
        $testMyData = new UserEntityManager(__DIR__ . '/../../src/model/UserData.json');
        $testMyData->save($mockArray);
        $importJSON = json_decode(file_get_contents(__DIR__ . '/../../src/model/UserData.json'), true, 512, JSON_THROW_ON_ERROR);
        $count = -1;
        foreach ($importJSON as $_) {
            $count++;
        }
        self::assertArrayHasKey('test', $importJSON[$count]);
    }

    /**
     * @throws JsonException
     */
    public function testSaveFileNotExi(): void // new dir testing
    {
        $mockArray = array(
            'test' => 'successful');
        $testMyData = new UserEntityManager($this->testData);
        $testMyData->save($mockArray);
        $importJSON = json_decode(file_get_contents($this->testData), true, 512, JSON_THROW_ON_ERROR);
        $count = -1;
        foreach ($importJSON as $_) {
            $count++;
        }
        self::assertArrayHasKey('test', $importJSON[$count]);
    }

    public function testSaveExcep() : void
    {

    }
}