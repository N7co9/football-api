<?php

namespace DTO;

class ErrorDTO
{
    public function __construct(
        public readonly string $message,
    )
    {
    }
}