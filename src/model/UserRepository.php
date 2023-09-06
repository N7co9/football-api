<?php

namespace model;

use JsonException;
use PHPUnit\Event\InvalidArgumentException;
use PHPUnit\Exception;

class UserRepository
{
    public function findByMail($mail): ?userDTO
    {
        $UserMapper = new \model\UserMapper();
        $UserDTOList = $UserMapper->JsonToDTO();

        foreach ($UserDTOList as $userDTO) {
            if ($userDTO->getEmail() === $mail) {
                return $userDTO;
            }
        }
        return null;
    }

    public function checkCombo(string $mail, string $password): bool
    {
        $userDTO = $this->findByMail($mail);

        if ($userDTO instanceof userDTO && password_verify($password, $userDTO->getPassword()))
            return true;

        return false;
    }
}