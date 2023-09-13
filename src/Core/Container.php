<?php
declare(strict_types=1);

namespace App\Core;

class Container
{
    private $dependencies = [];

    public function set(string $key, callable $resolver)
    {
        $this->dependencies[$key] = $resolver;
    }

    public function get(string $key)
    {
        if (isset($this->dependencies[$key])) {
            return $this->dependencies[$key]();
        }

        throw new \Exception("Dependency not found: $key");
    }
}
