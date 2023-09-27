<?php declare(strict_types=1);

namespace Model;

use App\Model\DTO\FavoriteDTO;
use App\Model\DTO\UserDTO;
use App\Model\UserEntityManager;
use App\Model\UserMapper;
use App\Model\UserRepository;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

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

        self::assertSame($return->name, 'Validation');
        self::assertSame($return->email, 'validation@validation.com');
        self::assertSame($return->passwort, '$2y$10$tsiHgW8K4/1cefEHapm3yOQCjWTpTDUAD4e2wh4FdiW2WO3tpkoJy');
    }

    public function testInvalidMail(): void
    {
        $mailexception = new UserRepository();
        self::assertNull($mailexception->findByMail('invalid-input'));
    }

    public function testCheckLoginCredentials(): void
    {
        $ur = new UserRepository();
        $dto = new UserDTO();
        $dto->email = 'validation@validation.com';
        $dto->passwort = 'Xyz12345*';
        $return = $ur->checkLoginCredentials($dto);
        self::assertTrue($return);
    }

    public function testInvalidLoginCredentials(): void
    {
        $ur = new UserRepository();
        $dto = new UserDTO();
        $dto->email = 'INVALID';
        $dto->passwort = 'INVALID';
        $return = $ur->checkLoginCredentials($dto);
        self::assertFalse($return);
    }

    public function testGetFavIDs() : void
    {
        $ur = new UserRepository();
        $res = $ur->getFavIDs('crazy@frog.com');

        self::assertSame('3', $res[0]);
    }

    public function testCheckIfFavIdAlreadyAdded() : void
    {
        $_SESSION['mail'] = 'not-empty';
        $ur = new UserRepository();
        $bool = $ur->checkIfFavIdAlreadyAdded('crazy@frog.com', '3');

        assertSame(true, $bool);
    }
}