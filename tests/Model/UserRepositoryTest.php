<?php declare(strict_types=1);

namespace Model;

use App\Model\DTO\FavoriteDTO;
use App\Model\DTO\UserDTO;
use App\Model\SQL\SqlConnector;
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
    public UserEntityManager $entityManager;
    public UserRepository $userRepository;

    public function setUp(): void
    {
        $this->entityManager = new UserEntityManager(new UserMapper());
        $this->userRepository = new UserRepository();

        $this->newUser = new UserDTO();
        $this->newUser->name = ('TEST');
        $this->newUser->email = ('TESTz@zTEST.COM');
        $this->newUser->passwort = ('$2y$10$hGVJpxSAGmoys3hfECyDh.bLHrw/hzRXoj3ZTHB6h0Pj46TA52adu');

        $_SESSION['mail'] = $this->newUser->email;

        $this->entityManager->saveCredentials($this->newUser);
        $id = $this->userRepository->getUserID($this->newUser->email);

        $this->entityManager->addFav("5", $id);

        parent::setUp();
    }

    public function testFindByMail(): void
    {
        $user = $this->userRepository->findByMail('TESTz@zTEST.COM');

        self::assertSame($user->name, 'TEST');
        self::assertSame($user->email, 'TESTz@zTEST.COM');
        self::assertSame($user->passwort, '$2y$10$hGVJpxSAGmoys3hfECyDh.bLHrw/hzRXoj3ZTHB6h0Pj46TA52adu');
    }

    public function testInvalidMail(): void
    {
        self::assertNull($this->userRepository->findByMail('invalid-input'));
    }

    public function testCheckLoginCredentials(): void
    {
        $testUserCredentials = new UserDTO();
        $testUserCredentials->email = 'TESTz@zTEST.COM';
        $testUserCredentials->passwort = 'Xyz12345*';

        $boolReturn = $this->userRepository->checkLoginCredentials($testUserCredentials);

        self::assertTrue($boolReturn);
    }

    public function testInvalidLoginCredentials(): void
    {
        $testUserCredentials = new UserDTO();
        $testUserCredentials->email = 'INVALID';
        $testUserCredentials->passwort = 'INVALID';

        $boolReturn = $this->userRepository->checkLoginCredentials($testUserCredentials);
        self::assertFalse($boolReturn);
    }

    public function testGetFavIDs(): void
    {
        $_SESSION['mail'] = 'TESTz@zTEST.COM';
        $id = $this->userRepository->getUserID($_SESSION['mail']);
        $result = $this->userRepository->getFavIDs($id);

        self::assertSame('5', $result[0]);
    }

    public function testCheckIfFavIdAlreadyAdded(): void
    {
        $bool = $this->userRepository->checkIfFavIdAlreadyAdded('TESTz@zTEST.COM', '5');

        assertSame(true, $bool);
    }

    public function testCheckIfFavIdAlreadyAddedFalse(): void
    {
        $bool = $this->userRepository->checkIfFavIdAlreadyAdded('TESTz@zTEST.COM', '6');

        assertSame(false, $bool);
    }

    public function testGetFavoritesWithOrderNumbers() : void
    {
        $_SESSION['mail'] = 'TESTz@zTEST.COM';
        $id = $this->userRepository->getUserID($_SESSION['mail']);

        $array = $this->userRepository->getFavoritesWithOrderNumbers($id);
        self::assertSame('5', $array[0]['favorite_id']);
        self::assertSame(1, $array[0]['order_number']);

    }
    public function tearDown(): void
    {
        $connector = new SqlConnector();
        $connector->executeDeleteQuery("DELETE FROM user_favorites;", []);
        $connector->executeDeleteQuery("DELETE FROM users;", []);
        $connector->closeConnection();
        parent::tearDown();
    }
}