<?php
declare(strict_types=1);

namespace App\Controller;

use JsonException;

class ApiHandling

{
    /**
     * @throws JsonException
     */
    public static function makeApiRequest($url)
    {
        $reqPrefs['http']['method'] = 'GET';
        $reqPrefs['http']['header'] = 'X-Auth-Token: a6c8d6df34f64da0a3d3bbe5beed6ea7';
        $stream_context = stream_context_create($reqPrefs);
        $response = file_get_contents($url, false, $stream_context);
        return json_decode($response, true, 512, JSON_THROW_ON_ERROR);
    }
}



/*

 ApiHandling should build the whole request everytime and only take - for example - the player id or the team id
 and return the right api response json. the api call should not be built in the controller.
 means you have to build new functions inside the ApiHandling class for each Controller that does exactly that.

 change the $this->value to what is happening in player controller
 you have to manipulate the $GET and not the value itself

 restructure the folder structure

 ALL CONTROLLER TESTS -> tests/Api
 ApiHandlingTest also -> tests/Api

 the goal is that we can separate the Api testing from the testing of the rest of the code!!

*/
