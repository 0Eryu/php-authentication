<?php
declare(strict_types=1);

namespace ServerConfiguration;

class Directive
{
    /**
     * @param string $directive
     * @return string
     */
    public function get(string $directive) : string
    {
        return ini_get($directive);
    }
}