<?php

namespace App\Core;
#Redirect
class Redirect
{
    private string $url = 'http://localhost:8079/';
    private object $redirectSpy;

    public function __construct(RedirectSpy $redirectSpy)
    {
        $this->redirectSpy = $redirectSpy;
    }

    public function to(string $location): void
    {
        $this->redirectSpy->sendHeader($this->url . $location);
        header('Location: ' . $this->url . $location);
    }
}