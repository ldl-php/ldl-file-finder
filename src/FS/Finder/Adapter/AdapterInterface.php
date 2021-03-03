<?php declare(strict_types=1);

namespace LDL\FS\Finder\Adapter;

use LDL\Validators\Chain\ValidatorChainInterface;

interface AdapterInterface
{
    public function find(iterable $directories): iterable;

    public function getValidatorChain(): ValidatorChainInterface;
}