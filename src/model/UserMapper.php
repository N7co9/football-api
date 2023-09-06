<?php

namespace model;

class UserMapper
{
    public function __construct(
        private string $jsonPath =__DIR__ . '/UserData2.json'
    )
    {
    }

    /**
     * @return userDTO[]
     */
    public function JsonToDTO (): array {

        $data = json_decode(file_get_contents($this->jsonPath), true);


        $userDTOList = [];

        foreach ($data as $entryData) {

            $userDTO = new userDTO();


            $userDTO->setEmail($entryData['email']);
            $userDTO->setPassword($entryData['password']);
            $userDTO->setName($entryData['name']);

            $userDTOList[] = $userDTO;
        }


        return $userDTOList;
    }

    /**
     * @param userDTO[] $userDTOList
     */
    public function DTO2Json (array $userDTOList): void {
        foreach ($userDTOList as $userDTO) {

            $entries[] = [
                'name' => $userDTO->getName(),
                'email' => $userDTO->getEmail(),
                'password' => $userDTO->getPassword()
            ];
        }

        $encoded = json_encode($entries, JSON_PRETTY_PRINT);
        file_put_contents($this->jsonPath, $encoded);

    }

}