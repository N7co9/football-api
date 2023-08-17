<?php
declare(strict_types=1);

namespace MyProject;

class ApiHandling

{
    public static function makeApiRequest($url)
    {
        $reqPrefs['http']['method'] = 'GET';
        $reqPrefs['http']['header'] = 'X-Auth-Token: a6c8d6df34f64da0a3d3bbe5beed6ea7';
        $stream_context = stream_context_create($reqPrefs);
        $response = file_get_contents($url, false, $stream_context);
        return json_decode($response, true);
    }
}