<?php declare(strict_types=1);

namespace App\Model;

use App\Model\DTO\UserDTO;
use JsonException;

class UserEntityManager
{
    public function __construct(
        private readonly UserMapper $userMapper,
    )
    {
    }

    /**
     * @throws JsonException
     */
    public function save(UserDTO $newUser): array
    {
        $userDTOList = $this->userMapper->JsonToDTO();
        $userDTOList[] = $newUser;
        $this->userMapper->DTO2Json($userDTOList);

        return $userDTOList;
    }

    /**
     * @throws JsonException
     */
    public function addFav($favID): void
    {
        $userDTOList = $this->userMapper->JsonToDTO();
        foreach ($userDTOList as $entry) {
            if (($entry->email === $_SESSION['mail'] && !in_array($favID, $entry->favIDs, true))) {
                $entry->favIDs[] = $favID;
            }
        }
        $this->userMapper->DTO2Json($userDTOList);
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