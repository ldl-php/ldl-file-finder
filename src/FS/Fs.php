<?php

namespace LDL\FsUtil\util;

class Fs
{
    public static function mkPath(...$params) : string
    {
        return implode(\DIRECTORY_SEPARATOR, $params);
    }

}
