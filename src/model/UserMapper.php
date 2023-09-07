<?php

namespace model;

use DTO\UserDTO;
use JsonException;

class UserMapper
{
    public function __construct(
        private readonly string $jsonPath = __DIR__ . '/UserData.json'
    )
    {
    }

    /**
     * @return userDTO[]
     */
    public function JsonToDTO(): array
    {

        $data = json_decode(file_get_contents($this->jsonPath), true, 512, JSON_THROW_ON_ERROR);
        $userDTOList = [];

        foreach ($data as $entryData) {
            $userDTO = new UserDTO();
            $userDTO->setEmail($entryData['email']);
            $userDTO->setPassword($entryData['password']);
            $userDTO->setName($entryData['name']);
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
                'name' => $userDTO->getName(),
                'email' => $userDTO->getEmail(),
                'password' => $userDTO->getPassword()
            ];
        }
        $encoded = json_encode($entries, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
        file_put_contents($this->jsonPath, $encoded);
    }
}