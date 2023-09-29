<?php

namespace App\Model;

use App\Model\DTO\UserDTO;
use App\Model\SQL\SqlConnector;


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

    public function getFavIDs(int $userId): ?array
    {
        $array = $this->sqlConnector->executeSelectQuery("SELECT user_favorites.favorite_id FROM user_favorites WHERE user_favorites.user_id = :userId ORDER BY order_number", ['userId' => $userId]);
        foreach ($array as $item)
        {
            $arrayOfFavIDs [] = $item['favorite_id'];
        }
        return $arrayOfFavIDs ?? null;
    }

    public function getUserID(string $mail) : ?int
    {
        $rawIdArray =  $this->sqlConnector->executeSelectQuery("SELECT users.id FROM users where users.email = :mail", [":mail" => $mail]);

        foreach ($rawIdArray as $entry){
            $formattedId = $entry['id'];
        }

        return $formattedId ?? null;
    }

    public function checkIfFavIdAlreadyAdded($mail, $favId): bool
    {
        if (!empty($_SESSION['mail'])) {
            if ((in_array($favId, $this->getFavIDs($this->getUserID($mail)) ?? [], true))) {
                return true;
            }
        }
        return false;
    }
    public function getFavoritesWithOrderNumbers($userId) : ?array
    {
        $sqlConnector = new SqlConnector();

        $query = "SELECT favorite_id, order_number FROM user_favorites WHERE user_id = :user_id";
        $params = [
            ":user_id" => $userId
            ] ;

        $result = $sqlConnector->executeSelectQuery($query, $params);

        $sqlConnector->closeConnection();

        return $result;
    }
}