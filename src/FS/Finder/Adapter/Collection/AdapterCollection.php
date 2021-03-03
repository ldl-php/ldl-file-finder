<?php declare(strict_types=1);

namespace LDL\FS\Finder\Adapter\Collection;

use LDL\FS\Finder\Adapter\AdapterInterface;
use LDL\Type\Collection\Traits\Validator\AppendValidatorChainTrait;
use LDL\Type\Collection\Types\Object\ObjectCollection;
use LDL\Validators\InterfaceComplianceValidator;

class AdapterCollection extends ObjectCollection
{
    use AppendValidatorChainTrait;

    public function __construct(iterable $items = null)
    {
        parent::__construct($items);
        $this->getAppendValidatorChain()
            ->append(new InterfaceComplianceValidator(AdapterInterface::class))
            ->lock();
    }
}