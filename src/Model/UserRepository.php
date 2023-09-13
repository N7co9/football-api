<?php

namespace App\Model;

use App\Model\DTO\UserDTO;
use JsonException;

class UserRepository
{
    /**
     * @throws JsonException
     */
    public function findByMail($mail): ?userDTO
    {
        $UserMapper = new UserMapper();
        $UserDTOList = $UserMapper->JsonToDTO();

        foreach ($UserDTOList as $userDTO) {
            if ($userDTO->getEmail() === $mail) {
                return $userDTO;
            }
        }
        return null;
    }

    /**
     * @throws JsonException
     */
    public function checkCombo(string $mail, string $password): bool
    {
        $userDTO = $this->findByMail($mail);
        if ($userDTO instanceof userDTO && password_verify($password, $userDTO->getPassword()))
            return true;

        return false;
    }
}