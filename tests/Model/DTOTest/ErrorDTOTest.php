<?php

namespace Model\DTOTest;

use App\Model\DTO\ErrorDTO;
use PHPUnit\Framework\TestCase;

class ErrorDTOTest extends TestCase
{
    public function testProperties(): void
    {
        $errorDTOTest = new ErrorDTO('error-test');
        self::assertSame('error-test', $errorDTOTest->getMessage());
    }
}