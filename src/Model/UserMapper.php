<?php

namespace App\Model;

use App\Model\DTO\UserDTO;
use JsonException;

class UserMapper
{
    public function __construct(
        private readonly string $jsonPath = __DIR__ . '/UserData.json'
    )
    {
    }

    public function JsonToDTO(): array
    {
        $data = json_decode(file_get_contents($this->jsonPath), true, 512, JSON_THROW_ON_ERROR);
        $userDTOList = [];

        foreach ($data as $entryData) {
            $userDTO = new UserDTO();
            $userDTO->email = ($entryData['email']);
            $userDTO->password = ($entryData['password']);
            $userDTO->name = ($entryData['name']);
            $userDTOList[] = $userDTO;
        }
        return $userDTOList;
    }

    /**
     * @param userDTO[] $userDTOList
     * @throws JsonException
     */
    public function DTO2Json(array $userDTOList): void
    {
        foreach ($userDTOList as $userDTO) {

            $entries[] = [
                'name' => $userDTO->name,
                'email' => $userDTO->email,
                'password' => $userDTO->password
            ];
        }
        $encoded = json_encode($entries, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
        file_put_contents($this->jsonPath, $encoded);
    }
}