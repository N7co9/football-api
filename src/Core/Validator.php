<?php

namespace App\Core;

use App\Model\DTO\ErrorDTO;

class Validator
{
    public mixed $errorDTOList;

    public function validate($userDTO): mixed
    {
        if (empty($userDTO->name) || !preg_match("/^[a-zA-Z-' ]*$/", $userDTO->name)) {
            $this->errorDTOList [] = new ErrorDTO('Oops, your name doesn\'t look right');
        }
        if (empty($userDTO->email) || !filter_var($userDTO->email, FILTER_VALIDATE_EMAIL)) {
            $this->errorDTOList [] = new ErrorDTO('Oops, your email doesn\'t look right');
        }
        if (!empty($userDTO->passwort && preg_match('@[A-Z]@', $userDTO->passwort) && preg_match('@[a-z]@', $userDTO->passwort) &&
            preg_match('@\d@', $userDTO->passwort) && preg_match('@\W@', $userDTO->passwort) &&
            (strlen($userDTO->passwort) > 6))) {
            $this->errorDTOList [] = '';
        } else {
            $this->errorDTOList [] = new ErrorDTO('Oops, your password doesn\'t look right!');
        }
        return $this->errorDTOList;
    }
}