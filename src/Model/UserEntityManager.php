<?php declare(strict_types=1);

namespace App\Model;

use App\Model\DTO\UserDTO;
use App\Model\SQL\SqlConnector;
use JsonException;

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


    public function addFav(string $favID, int $userID): void
    {
        $alreadyExistingFavIDs = $this->userRepository->getFavIDs($this->userRepository->getUserID($_SESSION['mail'])) ?? [];

        if (!in_array($favID, $alreadyExistingFavIDs, true)) {
            $query = "INSERT INTO user_favorites (user_id, favorite_id) VALUES (:user_id, :favid)";
            $params = [
                ':user_id' => $userID,
                ':favid' => $favID,
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

    public function moveUp(array $newFavIds, int $userID) : void
    {
        $this->userRepository->getFavIDs($userID);
    }
}