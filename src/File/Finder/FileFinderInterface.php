<?php declare(strict_types=1);

namespace LDL\File\Finder;

interface FileFinderInterface
{
    public function find(iterable $directories, bool $recursive = true): iterable;
}