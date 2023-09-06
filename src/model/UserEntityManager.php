<?php declare(strict_types=1);

namespace model;

use JsonException;

class UserEntityManager
{
    public function __construct(
        private readonly UserMapper $userMapper,
    )
    {
    }

    /**
     * @throws JsonException
     */
    public function save(userDTO $newUser)
    {
        $userDTOList = $this->userMapper->JsonToDTO();

        $userDTOList[] = $newUser;

        $this->userMapper->DTO2Json($userDTOList);
    }
}