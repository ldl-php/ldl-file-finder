<?php

namespace LDL\FS\Finder\Interfaces;

use LDL\FS\Type\Types\Generic\Collection\GenericFileCollection;

interface AdapterInterface
{
    /**
     * Finds an array of files in an array of directories
     *
     * @param array $directories
     * @param array $files
     * @param bool $includeDotFiles
     *
     * @return GenericFileCollection
     */
    public static function find(
        array $directories,
        array $files,
        bool $includeDotFiles=false
    ) : GenericFileCollection;

    /**
     * Find files through a regex
     *
     * @param string $regex
     * @param array $directories
     * @return GenericFileCollection
     */
    public static function findRegex(string $regex, array $directories): GenericFileCollection;

    /**
     * Finds files matching a regex
     *
     * @param string $match
     * @param array $directories
     * @return GenericFileCollection
     */
    public static function findMatching(string $match, array $directories) : GenericFileCollection;

}