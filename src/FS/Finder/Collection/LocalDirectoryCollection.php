<?php declare(strict_types=1);

namespace LDL\FS\Finder\Collection;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Type\Collection\Types\String\UniqueStringCollection;

class LocalDirectoryCollection extends UniqueStringCollection
{
    public function append($item, $key = null): CollectionInterface
    {
        $dir = realpath($item);

        if(false === $item || !is_dir($item)){
            throw new \InvalidArgumentException("Invalid directory specified $item");
        }

        return parent::append($dir);
    }
}