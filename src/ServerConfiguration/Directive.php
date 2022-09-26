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

    public function getInBytes(string $directive) : int
    {
        $directiveValue = $this->get($directive);
        preg_match('/([0-9]+)([gmk]?)/i', $directiveValue, $matches, PREG_OFFSET_CAPTURE);
        switch ($matches[2]) {
            case 'k':
                $matches[1] * 1024;
            case 'm':
                $matches[1] * 1024;
            case 'g':
                $matches[1] * 1024;
        }
    }
}