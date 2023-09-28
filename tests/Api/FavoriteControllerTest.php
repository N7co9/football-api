<?php

namespace Api;

use App\Controller\FavoriteController;
use App\Core\Api\ApiMapper;
use App\Core\Container;
use App\Core\DependencyProvider;
use App\Core\FavoritesLogic\FavManipulation;
use App\Core\Redirect;
use App\Core\View;
use App\Model\DTO\UserDTO;
use App\Model\UserEntityManager;
use App\Model\UserRepository;
use PHPUnit\Framework\TestCase;
use ReflectionObject;
use Twig\Loader\FilesystemLoader;

class FavoriteControllerTest extends TestCase
{

}