<?php declare(strict_types=1);

namespace LDL\File\Finder;

interface DirectoryInterface
{
    /**
     * @return bool
     */
    public function isRecursive(): bool;
}