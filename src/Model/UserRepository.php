<?php

namespace App\Model;

use App\Model\DTO\UserDTO;
use JsonException;

class UserRepository
{
    /**
     * @throws JsonException
     */
    public function findByMail(string $mail): ?UserDTO
    {
        $UserMapper = new UserMapper();
        $UserDTOList = $UserMapper->jsonToDTO();

        foreach ($UserDTOList as $userDTO) {
            if ($userDTO->email === $mail) {
                return $userDTO;
            }
        }
        return null;
    }

    /**
     * @throws JsonException
     */
    public function checkLoginCredentials(UserDTO $UserDTO): bool
    {
        $userDTO = $this->findByMail($UserDTO->email);
        if ($userDTO instanceof UserDTO && password_verify($UserDTO->passwort, $userDTO->passwort)) {
            return true;
        }
        return false;
    }

    public function getFavIDs(string $mail) : array
    {
        return $this->findByMail($mail)->favIDs;
    }
}