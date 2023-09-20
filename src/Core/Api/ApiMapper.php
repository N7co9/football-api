<?php

namespace App\Core\Api;

use App\Model\DTO\CompetitionDTO;
use App\Model\DTO\FavoriteDTO;
use App\Model\DTO\PlayerDTO;
use App\Model\DTO\StandingDTO;
use App\Model\DTO\TeamDTO;

class ApiMapper
{
    public function person($response) : PlayerDTO
    {
        $player = new PlayerDTO();
        $player->id = $response['id'];
        $player->firstName = $response['firstName'];
        $player->lastName = $response['lastName'];
        $player->name = $response['name'];
        $player->dateOfBirth = $response['dateOfBirth'];
        $player->nationality = $response['nationality'];
        $player->shirtNumber = $response['shirtNumber'] ?? '';

        return $player;
    }

    public function competition($response) : array
    {
        foreach ($response['competitions'] as $competition)
        {
            $competitionDTO = new CompetitionDTO();
            $competitionDTO->competitionName = $competition['name'];
            $competitionDTO->competitionCode = $competition['code'];
            $competitions [] = $competitionDTO;
        }
        return $competitions;
    }

    public function standing($response) : array
    {
        foreach ($response['standings'][0]['table'] as $standing){
            $standingDTO = new StandingDTO();

            $standingDTO->standingPosition = $standing['position'];
            $standingDTO->standingCrest = $standing['team']['crest'];
            $standingDTO->standingTeamId = $standing['team']['id'];
            $standingDTO->standingTeamName = $standing['team']['name'];
            $standingDTO->standingPlayedGames = $standing['playedGames'];
            $standingDTO->standingWon = $standing['won'];
            $standingDTO->standingDraw = $standing['draw'];
            $standingDTO->standingLost = $standing['lost'];
            $standingDTO->standingPoints = $standing['points'];
            $standingDTO->standingGoalsFor = $standing['goalsFor'];
            $standingDTO->standingGoalsAgainst = $standing['goalsAgainst'];
            $standingDTO->standingGoalDifference = $standing['goalDifference'];

            $ListOfStandingsDTO [] = $standingDTO;
        }
        return $ListOfStandingsDTO;
    }

    public function team($response) : array
    {
        foreach ($response['squad'] as $teamEntry){
            $teamDTO = new TeamDTO();
            $teamDTO->teamId = $teamEntry['id'];
            $teamDTO->teamName = $teamEntry['name'];

            $listOfTeamDTO [] = $teamDTO;
        }
        return $listOfTeamDTO;
    }

    public function favorite($response) : FavoriteDTO
    {
        $favoriteDTO = new FavoriteDTO();
        $favoriteDTO->id = $response['id'] ?? '';
        $favoriteDTO->name = $response['name'] ?? '';
        $favoriteDTO->crest = $response['crest'] ?? '';

        return $favoriteDTO;
    }
}