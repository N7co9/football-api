<?php

namespace Model;

use App\Model\DTO\UserDTO;
use App\Model\UserMapper;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\fileExists;

class UserMapperTest extends TestCase
{
    private UserMapper $userMapper;
    public array $userDTOList;

    public function setUp(): void
    {
        $this->userMapper = new UserMapper();
    }

    public function testSql2Dto(): void
    {
        $this->userDTOList = $this->userMapper->Sql2Dto();

        self::assertSame('', $this->userDTOList);
    }

    public function testDTO2Json(): void
    {
        $this->userDTOList = $this->userMapper->Sql2Dto();

        $return = $this->userMapper->Dto2Sql($this->userDTOList);

        self::assertSame('', $return);

    }

    public function tearDown(): void
    {
        unlink($this->testJsonPath);
        parent::tearDown();
    }
}
