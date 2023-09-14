<?php

namespace App\Core;

class RedirectSpy
{
    public array $capturedHeaders = [];

    public function sendHeader(string $header)
    {
        $this->capturedHeaders[] = $header;
    }
}