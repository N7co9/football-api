<?php declare(strict_types=1);

namespace core;

interface  ViewInterface
{
    public function addParameter(string $key, mixed $value): void;

    public function display(string $template);

}