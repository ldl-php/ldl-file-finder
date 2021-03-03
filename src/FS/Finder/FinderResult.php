<?php declare(strict_types=1);

namespace LDL\FS\Finder;

use LDL\Type\Collection\Traits\Validator\AppendValidatorChainTrait;
use LDL\Type\Collection\Types\Object\ObjectCollection;
use LDL\Validators\ClassComplianceValidator;

class FinderResult extends ObjectCollection
{
    use AppendValidatorChainTrait;

    public function __construct(
        iterable $items = null
    )
    {
        parent::__construct($items);

        $this->getAppendValidatorChain()
            ->append(new ClassComplianceValidator(FoundFile::class, $strict=true))
            ->lock();
    }
}