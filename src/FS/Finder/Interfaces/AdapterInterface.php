<?php

namespace LDL\FS\Finder\Interfaces;

use LDL\FS\Type\FileCollection;

interface AdapterInterface
{
    /**
     * Finds an array of files in an array of directories
     *
     * @param array $directories
     * @param array $files
     * @param bool $includeDotFiles
     *
     * @return FileCollection
     */
    public static function find(
        array $directories,
        array $files,
        bool $includeDotFiles=false
    ) : FileCollection;

    /**
     * Find files through a regex
     *
     * @param string $regex
     * @param array $directories
     * @return FileCollection
     */
    public static function findRegex(string $regex, array $directories): FileCollection;

    /**
     * Finds files matching a regex
     *
     * @param string $match
     * @param array $directories
     * @return FileCollection
     */
    public static function findMatching(string $match, array $directories) : FileCollection;

}