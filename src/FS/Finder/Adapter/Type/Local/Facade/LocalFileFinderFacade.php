<?php declare(strict_types=1);

namespace LDL\FS\Finder\Adapter\Type\Local\Facade;

use LDL\FS\Finder\Adapter\Collection\AdapterCollection;
use LDL\FS\Finder\Adapter\Type\Local\LocalFileFinderAdapter;
use LDL\FS\Finder\Collection\LocalDirectoryCollection;
use LDL\FS\Finder\FileFinder;
use LDL\FS\Finder\FinderResult;
use LDL\Validators\Chain\ValidatorChain;

class LocalFileFinderFacade
{
    public static function find(iterable $directories, iterable $validators=null) : iterable
    {
        $finder = new FileFinder(
            new AdapterCollection([
                new LocalFileFinderAdapter(new ValidatorChain($validators))
            ])
        );

        yield from $finder->find(new LocalDirectoryCollection($directories));
    }

    public static function findResult(iterable $directories, iterable $validators=null): FinderResult
    {
        return new FinderResult(self::find($directories, $validators));
    }
}