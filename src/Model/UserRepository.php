<?php

namespace App\Model;

use App\Model\DTO\UserDTO;
use JsonException;
use PHPUnit\Logging\Exception;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\throwException;

class UserRepository
{
    /**
     * @throws JsonException
     */
    public function findByMail(string $mail): ?UserDTO
    {
        $UserMapper = new UserMapper();
        $UserDTOList = $UserMapper->jsonToDTO();

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
    public function checkLoginCredentials(UserDTO $UserDTO): bool
    {
        $userDTO = $this->findByMail($UserDTO->email);
        if ($userDTO instanceof UserDTO && password_verify($UserDTO->passwort, $userDTO->passwort)) {
            return true;
        }
        return false;
    }

    /**
     * @throws JsonException
     */
    public function getFavIDs(string $mail): ?array
    {
        if (($this->findByMail($mail)) !== null){
            return $this->findByMail($mail)->favIDs;
        }
        return null;
    }

    /**
     * @throws JsonException
     */
    public function checkIfFavIdAlreadyAdded($mail, $favId): bool
    {
        if (!empty($_SESSION['mail'])) {
            if ((in_array($favId, $this->getFavIDs($mail) ?? [], true))) {
                return true;
            }
        }
        return false;
    }
}