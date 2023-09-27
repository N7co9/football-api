<?php

namespace App\Model\DTO;

class UserDTO
{
    public int $id = 0;
    public string $name = '';
    public string $email = '';
    public string $passwort = '';
    public array $favIDs = [];
}