<?php
namespace LDL\FS\Type;

use LDL\Type\Collection\Traits\Validator\ValueValidatorChainTrait;
use LDL\Type\Collection\Types\Object\Validator\ClassComplianceItemValidator;
use \LDL\Type\Collection\Types\Object\ObjectCollection;

class FileCollection extends ObjectCollection
{
    use ValueValidatorChainTrait;

    public function __construct(iterable $items = null)
    {
        parent::__construct($items);
        $this->getValueValidatorChain()
            ->append(new ClassComplianceItemValidator(\SplFileInfo::class))
            ->lock();
    }
}