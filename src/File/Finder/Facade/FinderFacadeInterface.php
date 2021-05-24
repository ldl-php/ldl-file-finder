<?php declare(strict_types=1);

namespace LDL\File\Finder\Facade;

use LDL\Validators\Chain\ValidatorChainInterface;

interface FinderFacadeInterface
{
    /**
     * @param iterable $directories
     * @param ValidatorChainInterface|null $chain
     * @param iterable|null $onAccept
     * @param iterable|null $onReject
     * @param iterable|null $onFile
     * @return iterable
     */
	public static function find(
        iterable $directories,
        ValidatorChainInterface $chain=null,
        iterable $onAccept=null,
        iterable $onReject=null,
        iterable $onFile=null
    ) : iterable;

}
