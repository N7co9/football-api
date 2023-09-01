<?php declare(strict_types=1);

namespace model;

use JsonException;

class UserEntityManager
{
    public function __construct(
        private readonly string $path,
    )
    {
    }

    /**
     * @throws JsonException
     */
    public function save($newUser)
    {
        if (!file_exists($this->path)) {
            $firstRecord = array($newUser);
            $dataToSave = $firstRecord;
        } else  {
            $oldRecords = json_decode(file_get_contents($this->path), false, 512, JSON_THROW_ON_ERROR);
            $oldRecords[] = $newUser;
            $dataToSave = $oldRecords;
        }

        $user_data = json_encode($dataToSave, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
        file_put_contents($this->path, $user_data, LOCK_EX);

        return array($dataToSave);
    }
}