<?php

namespace App\Core;
#Redirect
class Redirect implements RedirectInterface
{
    private string $url = 'http://localhost:8079/';

    public function to(string $location): void
    {
        header('Location: ' . $this->url . $location);
    }
}