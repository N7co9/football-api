<?php declare(strict_types=1);

namespace App\Model;

use App\Model\DTO\UserDTO;

class UserEntityManager
{
    public function __construct(
        private readonly UserMapper $userMapper,
    )
    {
    }

    public function save(UserDTO $newUser): array
    {
        $userDTOList = $this->userMapper->JsonToDTO();
        $userDTOList[] = $newUser;
        $this->userMapper->DTO2Json($userDTOList);

        return $userDTOList;
    }

    public function addFav($favID) : void
    {
        $userDTOList = $this->userMapper->JsonToDTO();
        foreach ($userDTOList as $entry) {
            if (($entry->email === $_SESSION['mail'])) {
                $entry->favIDs[] = $favID;
            }
        }
        $this->userMapper->DTO2Json($userDTOList);
    }

    public function remFav($favIDtoRemove) : void
    {
        $userDTOList = $this->userMapper->JsonToDTO();
        foreach ($userDTOList as $entry){
            if(($entry->email === $_SESSION['mail']) && !empty($entry->favIDs)) {
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
    public function manageFav(array $favIDs) : void
    {
        ksort($favIDs);
        $userDTOList = $this->userMapper->JsonToDTO();
        foreach ($userDTOList as $entry){
            if(($entry->email === $_SESSION['mail']) && !empty($entry->favIDs)) {
                $entry->favIDs = $favIDs;
            }
        }
        $this->userMapper->DTO2Json($userDTOList);
    }
}


// open closed & objects bei validierung
// typisierung
// TDD!!!
// FAVIDs als Array
// nicht mit String arbeiten!
// number up und number down soll mit arrays sorten!
// key->value zuordnen und dann einfach nur die zugehörigkeit ändern
// und dann array_sort ballern.