<?php declare(strict_types=1);

namespace LDL\File\Finder;

use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Type\Collection\AbstractTypedCollection;
use LDL\Type\Collection\Traits\Validator\AppendValueValidatorChainTrait;
use LDL\Validators\ClassComplianceValidator;

class FinderResult extends AbstractTypedCollection
{
    use AppendValueValidatorChainTrait;
    use CollectionInterfaceTrait;

    public function __construct(
        iterable $items = null
    )
    {
        parent::__construct($items);

        $this->getAppendValueValidatorChain()
            ->getChainItems()
            ->append(new ClassComplianceValidator(FoundFile::class, $strict=true))
            ->lock();
    }
}