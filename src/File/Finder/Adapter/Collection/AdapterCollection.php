<?php declare(strict_types=1);

namespace LDL\File\Finder\Adapter\Collection;

use LDL\File\Finder\Adapter\AdapterInterface;
use LDL\Type\Collection\AbstractTypedCollection;
use LDL\Type\Collection\Traits\Validator\AppendValueValidatorChainTrait;
use LDL\Type\Collection\Types\Object\ObjectCollection;
use LDL\Validators\InterfaceComplianceValidator;

class AdapterCollection extends AbstractTypedCollection
{
    use AppendValueValidatorChainTrait;

    public function __construct(iterable $items = null)
    {
        parent::__construct($items);
        $this->getAppendValueValidatorChain()
            ->getChainItems()
            ->append(new InterfaceComplianceValidator(AdapterInterface::class))
            ->lock();
    }
}