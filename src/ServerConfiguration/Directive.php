<?php
declare(strict_types=1);

namespace ServerConfiguration;

class Directive
{
    /**
     * @param string $directive
     * @return string
     */
    public static function get(string $directive) : string
    {
        return ini_get($directive);
    }

    /**
     * @param string $directive
     * @return int
     */
    public static function getInBytes(string $directive) : int
    {
        $directiveValue = Directive::get($directive);
        preg_match('/([0-9]+)([gmk]?)/i', $directiveValue, $matches);

        $value = (int) $matches[1];
        switch ($matches[2]) {
            case 'G':
                $value = $value * 1024;
            case 'M':
                $value = $value * 1024;
            case 'K':
                $value = $value * 1024;
        }
        return $$value;
    }

    public static function getUploadMaxFilesize() : int
    {
        return Directive::getInBytes("upload_max_filesize");
    }
}