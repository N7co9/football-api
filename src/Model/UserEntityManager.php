<?php declare(strict_types=1);

namespace App\Model;

use App\Model\DTO\UserDTO;
use App\Model\SQL\SqlConnector;
use JsonException;

class UserEntityManager
{
    public SqlConnector $sqlConnector;

    public function __construct(
        private readonly UserMapper $userMapper,
    )
    {
        $this->sqlConnector = new SqlConnector();
    }

    /**
     * @throws JsonException
     */
    public function saveCredentials(UserDTO $newUser): string
    {
        $data = $this->userMapper->mapFromDto2Array($newUser);
        $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";

        $params = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['passwort']
        ];

        return $this->sqlConnector->executeInsertQuery($query, $params);
    }


    public function addFav($favID, $user_id): void
    {
        $query = "INSERT INTO user_favorites (user_id, favorite_id) VALUES (:user_id, :favid)";
        $params = [
            ':user_id' => $user_id, // Replace with the actual user ID
            ':favid' => $favID, // Replace with the actual favorite ID
        ];

        $this->sqlConnector->executeInsertQuery($query, $params);
    }

    /**
     * @throws JsonException
     */
    public function remFav($favIDtoRemove): void
    {
        $userDTOList = $this->userMapper->JsonToDTO();
        foreach ($userDTOList as $entry) {
            if (($entry->email === $_SESSION['mail']) && in_array($favIDtoRemove, $entry->favIDs, true)) {
                foreach ($entry->favIDs as $key => $value) {
                    if ($value === $favIDtoRemove) {
                        unset($entry->favIDs[$key]);
                        $entry->favIDs = array_values($entry->favIDs);
                        ksort($entry->favIDs);
                    }
                }
            }
        }
        $this->userMapper->DTO2Json($userDTOList);
    }

    /**
     * @throws JsonException
     */
    public function manageFav(array $favIDs): void
    {
        ksort($favIDs);
        $userDTOList = $this->userMapper->JsonToDTO();
        foreach ($userDTOList as $entry) {
            if (($entry->email === $_SESSION['mail']) && !empty($entry->favIDs)) {
                $entry->favIDs = $favIDs;
            }
        }
        $this->userMapper->DTO2Json($userDTOList);
    }
}