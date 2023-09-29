<?php declare(strict_types=1);

namespace App\Model;

use App\Model\DTO\UserDTO;
use App\Model\SQL\SqlConnector;
use JsonException;
use PDOException;

class UserEntityManager
{
    public SqlConnector $sqlConnector;
    public UserRepository $userRepository;

    public function __construct(
        private readonly UserMapper $userMapper,
    )
    {
        $this->userRepository = new UserRepository();
        $this->sqlConnector = new SqlConnector();
    }

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


    public function addFav(string $favID, int $userID): void
    {
        $alreadyExistingFavIDs = $this->userRepository->getFavIDs($this->userRepository->getUserID($_SESSION['mail'])) ?? [];
        $orderNumber = count($alreadyExistingFavIDs);


        if (!in_array($favID, $alreadyExistingFavIDs, true)) {
            $query = "INSERT INTO user_favorites (user_id, favorite_id, order_number) VALUES (:user_id, :favid, :order_number)";
            $params = [
                ':user_id' => $userID,
                ':favid' => $favID,
                ':order_number' => $orderNumber + 1,
            ];
            $this->sqlConnector->executeInsertQuery($query, $params);
        }
    }


    public function remFav(string $favIDtoRemove, int $userID): void
    {
        $alreadyExistingFavIDs = $this->userRepository->getFavIDs($this->userRepository->getUserID($_SESSION['mail'])) ?? [];

        if (in_array($favIDtoRemove, $alreadyExistingFavIDs, true)) {
            $query = "DELETE FROM user_favorites WHERE favorite_id = :favID AND user_id = :userID";
            $params = [
                ':favID' => $favIDtoRemove,
                ':userID' => $userID
            ];
            $this->sqlConnector->executeDeleteQuery($query, $params);
        }
    }

    public function saveManipulatedOrder($manipulatedArray, $userId): void
    {
            foreach ($manipulatedArray as $arrayEntry) {
                $query = "UPDATE user_favorites SET order_number = :order_number WHERE user_id = :user_id AND favorite_id = :favorite_id";
                $params = [
                    ":order_number" => $arrayEntry['order_number'],
                    ":user_id" => $userId,
                    "favorite_id" => $arrayEntry['favorite_id']
                ];
                $this->sqlConnector->executeInsertQuery($query, $params);
            }
            $this->sqlConnector->closeConnection();
    }
}