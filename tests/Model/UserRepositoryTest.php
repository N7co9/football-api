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
        $result = $this->userRepository->getFavIDs('TESTz@zTEST.COM');

        self::assertContains('5', $result);
    }

    public function testCheckIfFavIdAlreadyAdded(): void
    {
        $bool = $this->userRepository->checkIfFavIdAlreadyAdded('TESTz@zTEST.COM', '5');

        assertSame(true, $bool);
    }

    public function tearDown(): void
    {
        $connector = new SqlConnector();
        $connector->executeDeleteQuery("DELETE FROM users;", []);
        parent::tearDown();
    }
}