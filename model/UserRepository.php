<?php

namespace model;

use JsonException;

class UserRepository
{
    /**
     * @throws JsonException
     */
    public function findByMail($mail): ?array
    {                      // needs to return boolean. is there a combo of hash and username in our json? if so -> true, if not false. controller does the rest.
        $array = json_decode(file_get_contents(__DIR__ . '/UserData.json'), true, 512, JSON_THROW_ON_ERROR);
        foreach ($array as $entry) {
            if ($entry['email'] === $mail) {
                $user [] = $entry['name'];
                $user [] = $entry['email'];
                $user [] = $entry['password'];
            }
        }
        return $user ?? null;
    }

    /**
     * @throws JsonException
     */
    public function checkCombo(string $mail, string $password): bool
    {
        $array = json_decode(file_get_contents(__DIR__ . '/UserData.json'), true, 512, JSON_THROW_ON_ERROR);
        foreach ($array as $entry) {
            if ($entry['email'] === $mail && password_verify($password, $entry['password']) === true) {
                return true;
            }
        }

        return false;
    }
}