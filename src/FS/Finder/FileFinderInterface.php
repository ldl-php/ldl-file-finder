<?php declare(strict_types=1);

namespace LDL\FS\Finder;

interface FileFinderInterface
{
    public function find(iterable $directories): iterable;
}