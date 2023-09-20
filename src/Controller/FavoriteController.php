<?php

namespace App\Controller;

use App\Core\Container;
use App\Core\Redirect;
use App\Model\UserEntityManager;
use App\Model\UserMapper;

class FavoriteController implements ControllerInterface
{
    private Redirect $redirect;
    public UserEntityManager $userEntityManager;

    public function __construct(Container $container)
    {
        $this->redirect = $container->get(Redirect::class);
        $this->userEntityManager = $container->get(UserEntityManager::class);

    }
    public function dataConstruct() : void
    {
        $action = $_GET['action'];
        $id = $_GET['id'];

        if($action === 'add' && !empty($_SESSION['mail'])){
            $this->userEntityManager->addFav($id);
        }
        if($action === 'remove' && !empty($_SESSION['mail'])){
            $this->userEntityManager->remFav($id);
        }
        $this->redirect->to('');
    }
}