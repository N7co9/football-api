<?php

namespace Api;

use App\Controller\ClubController;
use App\Core\Container;
use App\Core\DependencyProvider;
use App\Model\DTO\UserDTO;
use App\Model\SQL\SqlConnector;
use App\Model\UserEntityManager;
use App\Model\UserMapper;
use PHPUnit\Framework\TestCase;


class ClubControllerTest extends TestCase
{
    public UserEntityManager $userEntityManager;
    protected function setUp(): void
    {
        $containerBuilder = new Container();
        $dependencyProvider = new DependencyProvider();
        $dependencyProvider->provide($containerBuilder);
        $this->container = $containerBuilder;
        $this->construct = new ClubController($this->container);

        $this->userEntityManager = new UserEntityManager(new UserMapper());

        $newUser = new UserDTO();
        $newUser->email = 'TEST@TEST.com';

        $this->userEntityManager->saveCredentials($newUser);

        parent::setUp();
    }

    public function testDataConstruct(): void
    {
        $_GET['id'] = '3';
        $_SESSION['mail'] = 'TEST@TEST.com';

        $output = $this->construct->dataConstruct();

        self::assertSame('team.twig', $output->getTpl());
        self::assertSame('165', $output->getParameters()['team'][0]->teamId);
        self::assertSame('Niklas Lomb', $output->getParameters()['team'][0]->teamName);
        self::assertArrayHasKey('team', $output->getParameters());
    }

    protected function tearDown(): void
    {
        $connector = new SqlConnector();
        $connector->executeDeleteQuery("DELETE FROM user_favorites;", []);
        $connector->executeDeleteQuery("DELETE FROM users;", []);
        $connector->closeConnection();
        parent::tearDown();
        $_GET = [];
        parent::tearDown();
    }
}