<?php declare(strict_types=1);

namespace LDL\File\Finder\Adapter;

use LDL\Validators\Chain\ValidatorChainInterface;

interface AdapterInterface
{
    /**
     * @param iterable $locations
     * @param bool $recursive
     * @return iterable
     */
    public function find(iterable $locations, bool $recursive = true): iterable;

    /**
     * Obtains the chain of validators
     *
     * @return null|ValidatorChainInterface
     */
    public function getValidatorChain(): ?ValidatorChainInterface;

    /**
     * @return int
     */
    public function getTotalFileCount() : int;
}
