<?php

namespace model;

use JsonException;

class UserEntityManager
{
    /**
     * @throws JsonException
     */
    public function save($newUser): void
    {
        if (!file_exists(__DIR__ . '/../model/UserData.json')) {
            $firstRecord = array($newUser);
            $dataToSave = $firstRecord;
        } else {
            $oldRecords = json_decode(file_get_contents(__DIR__ . '/../model/UserData.json'), false, 512, JSON_THROW_ON_ERROR);
            $oldRecords[] = $newUser;
            $dataToSave = $oldRecords;
        }
        $user_data = json_encode($dataToSave, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
        file_put_contents(__DIR__ . '/../model/UserData.json', $user_data, LOCK_EX);
    }
}