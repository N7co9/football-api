<?php

namespace Controller;

use App\Controller\RegistrationController;
use App\Core\Container;
use App\Core\DependencyProvider;
use App\Model\DTO\UserDTO;
use PHPUnit\Framework\TestCase;

class RegistrationControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $containerBuilder = new Container();
        $dependencyProvider = new DependencyProvider();
        $dependencyProvider->provide($containerBuilder);

        $this->container = $containerBuilder;
        $this->construct = new RegistrationController($this->container);


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
        $_POST['mail'] = 'validation@validation.com';
        $_POST['passwort'] = 'Xyz12345*';

        $output = $this->construct->dataConstruct();

        self::assertSame('registration.twig', $output->getTpl());
        self::assertSame('TEST', $output->getParameters()['vName']);
        self::assertSame('validation@validation.com', $output->getParameters()['vMail']);
        self::assertSame('Oops, your email is already registered!', $output->getParameters()['errors'][0]->message);
    }
    protected function tearDown(): void
    {
        $getContents = file_get_contents(__DIR__ . '/../../src/Model/UserData.json',);
        $arrayFromJSON = json_decode($getContents, true);

        $count = count($arrayFromJSON) - 1;

        if(($arrayFromJSON[$count]['name']) === 'TEST'){
            array_pop($arrayFromJSON);
            $encoded = json_encode($arrayFromJSON, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
            file_put_contents(__DIR__ . '/../../src/Model/UserData.json', $encoded);
        }
        parent::tearDown();
    }
}
