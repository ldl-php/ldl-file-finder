<?php declare(strict_types=1);

namespace LDL\File\Finder\Facade;

use LDL\Validators\Chain\ValidatorChainInterface;

interface FinderFacadeInterface
{
    /**
     * @param iterable $directories
     * @param bool $recursive
     * @param ValidatorChainInterface|null $chain
     * @return iterable
     */
	public static function find(
        iterable $directories,
        bool $recursive = true,
        ValidatorChainInterface $chain=null
    ) : iterable;

}
