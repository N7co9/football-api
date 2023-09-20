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
        foreach ($userDTOList as $entry){
            if($entry->email === $_SESSION['mail']){
                if(empty($entry->favIDs)){
                    $entry->favIDs = $favID;
                } else if(!empty($entry->favIDs)){
                    $entry->favIDs .=', ' . $favID;
                }
            }
        }
        $this->userMapper->DTO2Json($userDTOList);
    }

    public function remFav($favID) : void
    {
        $userDTOList = $this->userMapper->JsonToDTO();
        foreach ($userDTOList as $entry){
            if(($entry->email === $_SESSION['mail']) && !empty($entry->favIDs) && strlen($entry->favIDs) > 5) {
                $entry->favIDs = str_replace(', ' . $favID, '', $entry->favIDs);
            }
            $entry->favIDs = str_replace($favID, '', $entry->favIDs);
        }
        $this->userMapper->DTO2Json($userDTOList);
    }
}