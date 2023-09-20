<?php declare(strict_types=1);

namespace App\Core\Api;


class ApiHandling {

    public function __construct(ApiMapper $apiMapper)
    {
        $this->apiMapper = $apiMapper;
    }

    public function getClient()
    {
        return $this->makeApiRequest('competitions/');
    }

    public function getPerson(int $playerId): \App\Model\DTO\PlayerDTO
    {
        $response = $this->makeApiRequest('persons/' .  $playerId);
        return $this->apiMapper->person($response);
    }

    public function getCompetitions()
    {
        $response = $this->makeApiRequest('competitions/');
        return $this->apiMapper->competition($response);
    }

    public function getStandings(string $leagueId)
    {
        $response = $this->makeApiRequest('competitions/' . $leagueId . '/standings');
        return $this->apiMapper->standing($response);
    }

    public function getTeam(string $teamId)
    {
        $response = $this->makeApiRequest('teams/' . $teamId);
        return $this->apiMapper->team($response);
    }

    private function makeApiRequest(string $url): array
    {
        $reqPrefs['http']['method'] = 'GET';
        $reqPrefs['http']['header'] = 'X-Auth-Token: a6c8d6df34f64da0a3d3bbe5beed6ea7';
        $stream_context = stream_context_create($reqPrefs);
        $response = file_get_contents('http://api.football-data.org/v4/' . $url, false, $stream_context);
        return json_decode($response, true, 512, JSON_THROW_ON_ERROR);
    }
}

