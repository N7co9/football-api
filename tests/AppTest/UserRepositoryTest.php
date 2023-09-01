<?php declare(strict_types=1);

namespace AppTest;

use JsonException;
use model\UserRepository;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    /**
     * @throws JsonException
     */
    public function testFindByMail(): void
    {
        $testFindByMail = new UserRepository();
        $findByMailArray = $testFindByMail->findByMail('MeinName@mail.com');

        self::assertSame('MeinName@mail.com', $findByMailArray['email']);
        self::assertSame('MeinName', $findByMailArray['name']);
        self::assertSame('$2y$10$T8s/vZhNXtT/1NwtfT04hOx7SfM2mfeIr2n5v/maEgdVMJRFOldRa', $findByMailArray['password']);

    }

    /**
     * @throws JsonException
     */
    public function testInvalidMail(): void
    {
        $mailexception = new UserRepository();
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('invalid email');
        $mailexception->findByMail('invalid-input');
    }

    /**
     * @throws JsonException
     */
    public function testCheckCombo(): void
    {
        $testCheckCombo = new UserRepository();
        $checkComboBoolean = $testCheckCombo->checkCombo('MeinName@mail.com', 'Xyz12345*');

        self::assertTrue($checkComboBoolean);
    }

    /**
     * @throws JsonException
     */
    public function testInvalidCombo(): void
    {
        $combo = new UserRepository();
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('invalid input or no combination found');

        $combo->checkCombo('invalid-input', 'invalid-input');
    }
}