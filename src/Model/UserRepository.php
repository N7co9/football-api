<?php

namespace App\Model;

use App\Model\DTO\UserDTO;
use JsonException;

class UserRepository
{
    /**
     * @throws JsonException
     */
    public function findByMail(string $mail): ?usERdtO
    {
        $UserMapper = new UserMapper();
        $UserDTOList = $UserMapper->JsonToDTO();

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
    public function checkCombo(string $mail, string $password): bool // implement DTO
    {
        $userDTO = $this->findByMail($mail);
        if ($userDTO instanceof userDTO && password_verify($password, $userDTO->password))
            return true;

        return false;
    }
}