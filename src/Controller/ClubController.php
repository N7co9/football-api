<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Api\ApiHandling;
use App\Core\Api\ApiMapper;
use App\Core\Container;
use App\Core\View;
use App\Model\UserRepository;
use JsonException;

class ClubController implements ControllerInterface
{
    private View $templateEngine;
    public UserRepository $userRepository;

    public function __construct(Container $container)
    {
        $this->templateEngine = $container->get(View::class);
        $this->ApiMapper = $container->get(ApiMapper::class);
        $this->userRepository = $container->get(UserRepository::class);
    }

    /**
     * @throws JsonException
     */
    public function dataConstruct(): object
    {
        $teamId = $_GET['id'];
        $result = new ApiHandling($this->ApiMapper);
        $result = $result->getTeam($teamId);

        $bool = $this->userRepository->checkIfFavIdAlreadyAdded($_SESSION['mail'] ?? '', $teamId);

        $this->templateEngine->addParameter('isAdded', $bool);
        $this->templateEngine->addParameter('user', $_SESSION['mail'] ?? '');
        $this->templateEngine->addParameter('team', $result);
        $this->templateEngine->addParameter('id', $teamId);
        $this->templateEngine->setTemplate('team.twig');

        return $this->templateEngine;
    }
}