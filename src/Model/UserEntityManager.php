<?php declare(strict_types=1);

namespace App\Model;

use App\Model\DTO\UserDTO;

class UserEntityManager
{
    public function __construct(
        private readonly UserMapper $userMapper,
    )
    {
    }

    public function save(UserDTO $newUser): array
    {
        $userDTOList = $this->userMapper->JsonToDTO();
        $userDTOList[] = $newUser;
        $this->userMapper->DTO2Json($userDTOList);

        return $userDTOList;
    }
}