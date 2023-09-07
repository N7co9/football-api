<?php declare(strict_types=1);

namespace AppTest;

use JsonException;
use model\UserRepository;
use PHPUnit\Framework\TestCase;

/**
 * Name = Validation
 * Email = validation@validation.com
 * Password = Xyz12345*
 */


class UserRepositoryTest extends TestCase
{
   public function testFindByMail(): void
    {
        $email = 'validation@validation.com';

        $ur = new UserRepository();
        $return = $ur->findByMail($email);

        self::assertSame($return->getName(), 'Validation');
        self::assertSame($return->getEmail(), 'validation@validation.com');
        self::assertSame($return->getPassword(), '$2y$10$tsiHgW8K4/1cefEHapm3yOQCjWTpTDUAD4e2wh4FdiW2WO3tpkoJy');
    }

    public function testInvalidMail(): void
    {
        $mailexception = new UserRepository();
        $return = $mailexception->findByMail('invalid-input');
        self::assertNull($return);
    }

    public function testCheckCombo(): void
    {
        $ur = new UserRepository();
        $return = $ur->checkCombo('validation@validation.com', 'Xyz12345*');
        self::assertTrue($return);
    }

    public function testInvalidCombo(): void
    {
        $ur = new UserRepository();
        $return = $ur->checkCombo('', '');
        self::assertFalse($return);
    }
}