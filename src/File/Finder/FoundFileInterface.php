<?php declare(strict_types=1);

namespace LDL\File\Finder;

use LDL\Framework\Base\Contracts\Type\ToStringInterface;
use LDL\Validators\Collection\ValidatorCollectionInterface;

interface FoundFileInterface extends ToStringInterface
{

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @return mixed
     */
    public function getFileObject();

    /**
     * @return ValidatorCollectionInterface|null
     */
    public function getValidators(): ?ValidatorCollectionInterface;

}