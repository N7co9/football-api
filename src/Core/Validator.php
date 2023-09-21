<?php

namespace App\Core;

use App\Model\DTO\ErrorDTO;

class Validator
{
    public function validate($userDTO): array
    {
        $errorDTOList = [];
        $this->validateName($userDTO, $errorDTOList);
        $this->validateEmail($userDTO, $errorDTOList);
        $this->validatePassword($userDTO, $errorDTOList);

        return $errorDTOList;
    }

    private function validateName($userDTO, &$errorDTOList) : void
    {
        if (empty($userDTO->name) || !preg_match("/^[a-zA-Z-' ]*$/", $userDTO->name)) {
            $errorDTOList[] = new ErrorDTO('Oops, your name doesn\'t look right');
        }
    }

    private function validateEmail($userDTO, &$errorDTOList) : void
    {
        if (empty($userDTO->email) || !filter_var($userDTO->email, FILTER_VALIDATE_EMAIL)) {
            $errorDTOList[] = new ErrorDTO('Oops, your email doesn\'t look right');
        }
    }

    private function validatePassword($userDTO, &$errorDTOList) : void
    {
        if (
            empty($userDTO->passwort) ||
            !preg_match('@[A-Z]@', $userDTO->passwort) ||
            !preg_match('@[a-z]@', $userDTO->passwort) ||
            !preg_match('@\d@', $userDTO->passwort) ||
            !preg_match('@\W@', $userDTO->passwort) ||
            (strlen($userDTO->passwort) <= 6)
        ) {
            $errorDTOList[] = new ErrorDTO('Oops, your password doesn\'t look right!');
        }
    }
}
// favorites have to be saved in a DTO !!!