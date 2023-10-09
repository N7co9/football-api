<?php

namespace Controller;

use App\Controller\RegistrationController;
use App\Core\Container;
use App\Core\DependencyProvider;
use App\Model\DTO\UserDTO;
use App\Model\SQL\SqlConnector;
use App\Model\UserEntityManager;
use App\Model\UserMapper;
use PHPUnit\Framework\TestCase;

class RegistrationControllerTest extends TestCase
{
    public SqlConnector $sqlConnector;
    public UserEntityManager $entityManager;

    protected function setUp(): void
    {
        $this->sqlConnector = new SqlConnector();

        $containerBuilder = new Container();
        $dependencyProvider = new DependencyProvider();
        $dependencyProvider->provide($containerBuilder);

        $this->container = $containerBuilder;
        $this->construct = new RegistrationController($this->container);
        $this->entityManager = new UserEntityManager(new UserMapper());

        parent::setUp();
    }

    public function testDataConstructValid() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['name'] = 'TEST';
        $_POST['mail'] = 'TEST@TEST.com';
        $_POST['passwort'] = 'Xyz12345*';

        $output = $this->construct->dataConstruct();

        // since the Input is Valid, the Registration Controller will reset the vName & vMail
        // values to '' -> if not Valid the Name and Mail values would persist.

        self::assertSame('registration.twig', $output->getTpl());
        self::assertSame('', $output->getParameters()['vName']);
        self::assertSame('', $output->getParameters()['vMail']);
        self::assertSame('Success. Welcome abroad!', $output->getParameters()['errors'][0]->message);
    }
    public function testDataConstructInvalidName() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['name'] = 'INVALID-NAME(!123)';
        $_POST['mail'] = 'TEST@TEST.com';
        $_POST['passwort'] = 'Xyz12345*';


        $output = $this->construct->dataConstruct();

        self::assertSame('registration.twig', $output->getTpl());
        self::assertSame('INVALID-NAME(!123)', $output->getParameters()['vName']);
        self::assertSame('TEST@TEST.com', $output->getParameters()['vMail']);
        self::assertSame('Oops, your name doesn\'t look right', $output->getParameters()['errors'][0]->message);
    }
    public function testDataConstructInvalidEmail() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['name'] = 'TEST';
        $_POST['mail'] = 'INVALID-EMAIL';
        $_POST['passwort'] = 'Xyz12345*';

        $output = $this->construct->dataConstruct();

        self::assertSame('registration.twig', $output->getTpl());
        self::assertSame('TEST', $output->getParameters()['vName']);
        self::assertSame('INVALID-EMAIL', $output->getParameters()['vMail']);
        self::assertSame('Oops, your email doesn\'t look right', $output->getParameters()['errors'][0]->message);
    }
    public function testDataConstructInvalidPasswort() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['name'] = 'TEST';
        $_POST['mail'] = 'TEST@TEST.com';
        $_POST['passwort'] = 'INVALID-PASSWORT';

        $output = $this->construct->dataConstruct();

        self::assertSame('registration.twig', $output->getTpl());
        self::assertSame('TEST', $output->getParameters()['vName']);
        self::assertSame('TEST@TEST.com', $output->getParameters()['vMail']);
        self::assertSame('Oops, your password doesn\'t look right!', $output->getParameters()['errors'][0]->message);
    }
    public function testDataConstructInvalidNameAndInvalidEmail() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['name'] = 'INVALID-NAME(!123)';
        $_POST['mail'] = 'INVALID-EMAIL';
        $_POST['passwort'] = 'Xyz12345*';

        $output = $this->construct->dataConstruct();

        self::assertSame('registration.twig', $output->getTpl());
        self::assertSame('INVALID-NAME(!123)', $output->getParameters()['vName']);
        self::assertSame('INVALID-EMAIL', $output->getParameters()['vMail']);
        self::assertSame('Oops, your name doesn\'t look right', $output->getParameters()['errors'][0]->message);
        self::assertSame('Oops, your email doesn\'t look right', $output->getParameters()['errors'][1]->message);
    }
    public function testDataConstructInvalidNameAndInvalidPasswort() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['name'] = 'INVALID-NAME(!123)';
        $_POST['mail'] = 'TEST@TEST.com';
        $_POST['passwort'] = 'INVALID-PASSWORT';

        $output = $this->construct->dataConstruct();

        self::assertSame('registration.twig', $output->getTpl());
        self::assertSame('INVALID-NAME(!123)', $output->getParameters()['vName']);
        self::assertSame('TEST@TEST.com', $output->getParameters()['vMail']);
        self::assertSame('Oops, your name doesn\'t look right', $output->getParameters()['errors'][0]->message);
        self::assertSame('Oops, your password doesn\'t look right!', $output->getParameters()['errors'][1]->message);
    }
    public function testDataConstructInvalidEmailAndInvalidPasswort() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['name'] = 'TEST';
        $_POST['mail'] = 'INVALID-EMAIL';
        $_POST['passwort'] = 'INVALID-PASSWORT';

        $output = $this->construct->dataConstruct();

        self::assertSame('registration.twig', $output->getTpl());
        self::assertSame('TEST', $output->getParameters()['vName']);
        self::assertSame('INVALID-EMAIL', $output->getParameters()['vMail']);
        self::assertSame('Oops, your email doesn\'t look right', $output->getParameters()['errors'][0]->message);
        self::assertSame('Oops, your password doesn\'t look right!', $output->getParameters()['errors'][1]->message);
    }

    public function testDataConstructAllInvalid() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['name'] = 'INVALID-NAME(!123)';
        $_POST['mail'] = 'INVALID-EMAIL';
        $_POST['passwort'] = 'INVALID-PASSWORT';

        $output = $this->construct->dataConstruct();

        self::assertSame('registration.twig', $output->getTpl());
        self::assertSame('INVALID-NAME(!123)', $output->getParameters()['vName']);
        self::assertSame('INVALID-EMAIL', $output->getParameters()['vMail']);
        self::assertSame('Oops, your name doesn\'t look right', $output->getParameters()['errors'][0]->message);
        self::assertSame('Oops, your email doesn\'t look right', $output->getParameters()['errors'][1]->message);
        self::assertSame('Oops, your password doesn\'t look right!', $output->getParameters()['errors'][2]->message);
    }
    public function testDataConstructEmailNotUnique() : void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['name'] = 'TEST';
        $_POST['mail'] = 'TEST@TEST.com';
        $_POST['passwort'] = 'Xyz12345*';

        $putEmailInSystem = new UserDTO();
        $putEmailInSystem->email = 'TEST@TEST.com';
        $this->entityManager->saveCredentials($putEmailInSystem);


        $output = $this->construct->dataConstruct();

        self::assertSame('registration.twig', $output->getTpl());
        self::assertSame('TEST', $output->getParameters()['vName']);
        self::assertSame('TEST@TEST.com', $output->getParameters()['vMail']);
        self::assertSame('Oops, your email is already registered!', $output->getParameters()['errors'][0]->message);
    }
    protected function tearDown(): void
    {
        $connector = new SqlConnector();
        $connector->executeDeleteQuery("DELETE FROM user_favorites;", []);
        $connector->executeDeleteQuery("DELETE FROM users;", []);
        $this->sqlConnector->closeConnection();
        parent::tearDown();
    }
}
