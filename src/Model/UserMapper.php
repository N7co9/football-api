<?php

namespace App\Model;

use App\Model\DTO\UserDTO;
use App\Model\SQL\SqlConnector;
use JsonException;

class UserMapper
{
    public function __construct()
    {
    }


    public function mapFromArray2Dto(array $data): ?UserDTO
    {
        foreach ($data as $entry) {
            $userDTO = new UserDTO();
            $userDTO->id = $entry['id'];
            $userDTO->name = $entry['name'];
            $userDTO->email = $entry['email'];
            $userDTO->passwort = $entry['password'];
            $userDTO->favIDs = $entry['fav-ids'] ?? [];

        }
        return $userDTO ?? null;
    }

    public function mapFromDto2Array(UserDTO $userDTO): array
    {
        return array(
            "id" => $userDTO->id,
            "name" => $userDTO->name,
            "email" => $userDTO->email,
            "passwort" => $userDTO->passwort,
            "fav-ids" => [$userDTO->favIDs]
        );
    }
}