<?php

namespace App\Core;
#RedirectMock
class RedirectSpy implements RedirectInterface
{
    public string $location = '';

    public function to(string $location): void
    {
        $this->location = $location;
    }
}