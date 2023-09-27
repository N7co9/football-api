<?php

namespace App\Model;

use App\Model\DTO\UserDTO;
use App\Model\SQL\SqlConnector;
use JsonException;


class UserRepository
{
    public UserMapper $userMapper;
    public SqlConnector $sqlConnector;
    public function __construct()
    {
        $this->userMapper = new UserMapper();
        $this->sqlConnector = new SqlConnector();
    }
    public function findByMail(string $mail): ?UserDTO
    {
        $array = $this->sqlConnector->executeSelectQuery("SELECT * FROM users where email = :mail", [':mail' => $mail]);
        return $this->userMapper->mapFromArray2Dto($array);
    }

    public function checkLoginCredentials(UserDTO $UserDTO): bool
    {
        $userDTO = $this->findByMail($UserDTO->email);
        if ($userDTO instanceof UserDTO && password_verify($UserDTO->passwort, $userDTO->passwort)) {
            return true;
        }
        return false;
    }

    public function getFavIDs(string $mail): ?array
    {
        $array = $this->sqlConnector->executeSelectQuery("SELECT user_favorites.favorite_id FROM user_favorites INNER JOIN users ON users.id = user_favorites.user_id WHERE users.email = :mail", ['mail' => $mail]);
        foreach ($array as $item)
        {
            $arrayOfFavIDs [] = $item['favorite_id'];
        }
        return $arrayOfFavIDs ?? null;
    }

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