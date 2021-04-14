<?php declare(strict_types=1);

namespace LDL\FS\Finder\Adapter\Type\Local\Facade;

use LDL\FS\Finder\Adapter\Collection\AdapterCollection;
use LDL\FS\Finder\Adapter\Type\Local\LocalFileFinderAdapter;
use LDL\FS\Finder\Collection\LocalDirectoryCollection;
use LDL\FS\Finder\Facade\FinderFacadeInterface;
use LDL\FS\Finder\FileFinder;
use LDL\FS\Finder\FinderResult;
use LDL\Validators\Chain\ValidatorChain;

class LocalFileFinderFacade implements FinderFacadeInterface
{
    public static function find(
        iterable $directories,
        iterable $validators=null,
        iterable $onAccept=null,
        iterable $onReject=null,
        iterable $onFile=null
    ) : iterable
    {
        $l = new LocalFileFinderAdapter(new ValidatorChain($validators));

        if(null !== $onAccept){
            $l->onAccept()->appendMany($onAccept);
        }

        if(null !== $onReject){
            $l->onReject()->appendMany($onReject);
        }

        if(null !== $onFile){
            $l->onFile()->appendMany($onFile);
        }

        yield from (new FileFinder(
            new AdapterCollection([
                $l
            ])
        ))
        ->find(new LocalDirectoryCollection($directories));
    }

    public static function findResult(
        iterable $directories,
        iterable $validators=null,
        iterable $onAccept=null,
        iterable $onReject=null,
        iterable $onFile=null
    ): FinderResult
    {
        return new FinderResult(
            self::find(
                $directories,
                $validators,
                $onAccept,
                $onReject,
                $onFile
            )
        );
    }
}