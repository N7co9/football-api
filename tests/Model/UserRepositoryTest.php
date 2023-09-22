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
        $return = $mailexception->findByMail('invalid-input');
        self::assertNull($return);
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

    public function testCheckIfFavIdAlreadyAddedTrue() : void
    {
        $newUser = new UserDTO();
        $newUser->name = ('N4ME');
        $newUser->email = ('EMAIL');
        $newUser->passwort = ('PASSWORT');
        $newUser->favIDs = ["5"];

        $entityManager = new UserEntityManager(new UserMapper());
        $entityManager->save($newUser);

        $_SESSION['mail'] = $newUser->email;

        $ur = new UserRepository();
        $bool = $ur->checkIfFavIdAlreadyAdded('EMAIL', '5');

        self::assertTrue($bool);
    }
    public function testCheckIfFavIdAlreadyAddedFalse() : void
    {
        $newUser = new UserDTO();
        $newUser->name = ('N4ME');
        $newUser->email = ('EMAIL');
        $newUser->passwort = ('PASSWORT');
        $newUser->favIDs = ["5"];

        $entityManager = new UserEntityManager(new UserMapper());
        $entityManager->save($newUser);

        $_SESSION['mail'] = $newUser->email;

        $ur = new UserRepository();
        $bool = $ur->checkIfFavIdAlreadyAdded('EMAIL', '6');

        self::assertFalse($bool);
    }
    public function tearDown(): void
    {

        $getContents = file_get_contents(__DIR__ . '/../../src/Model/UserData.json',);
        $arrayFromJSON = json_decode($getContents, true);

        if (!empty($arrayFromJSON)) {
            $count = count($arrayFromJSON) - 1;
        }

        if (($arrayFromJSON[$count ?? null]['name']) === 'N4ME') {
            array_pop($arrayFromJSON);
            $encoded = json_encode($arrayFromJSON, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
            file_put_contents(__DIR__ . '/../../src/Model/UserData.json', $encoded);
        }
        parent::tearDown();
    }
}