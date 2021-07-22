<?php declare(strict_types=1);

namespace LDL\File\Finder;

use LDL\Validators\Collection\ValidatorCollectionInterface;

interface FoundFileInterface
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
     * @return ValidatorCollectionInterface
     */
    public function getValidators(): ValidatorCollectionInterface;

}