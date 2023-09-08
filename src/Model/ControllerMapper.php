<?php

namespace App\Model;

use App\Model\DTO\ControllerDTO;

class ControllerMapper
{
    public function __construct(
        public readonly string $jsonPath = __DIR__ . '/Routes.json'
    )
    {
    }

    public function JsonToDTO(): array
    {

        $data = json_decode(file_get_contents($this->jsonPath), true, 512, JSON_THROW_ON_ERROR);
        $controllerDTOlist = [];
        foreach ($data as $entryData) {
            $controllerDTO = new ControllerDTO();
            $controllerDTO->setController($entryData['controller']);
            $controllerDTO->setQuery($entryData['query']);
            $controllerDTOlist[] = $controllerDTO;
        }
        return $controllerDTOlist;
    }
}