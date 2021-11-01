<?php declare(strict_types=1);

namespace LDL\File\Finder;

use LDL\Validators\Collection\ValidatorCollectionInterface;

class FoundFile implements FoundFileInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var mixed
     */
    private $fileObject;

    /**
     * @var ValidatorCollectionInterface
     */
    private $validators;

    public function __construct(string $path, $fileObject, ValidatorCollectionInterface $result = null)
    {
        $this->path = $path;
        $this->fileObject = $fileObject;
        $this->validators = $result;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getFileObject()
    {
        return $this->fileObject;
    }

    /**
     * @return ValidatorCollectionInterface
     */
    public function getValidators(): ?ValidatorCollectionInterface
    {
        return $this->validators;
    }

    public function toString(): string
    {
        return $this->getPath();
    }

    public function __toString() : string
    {
        return $this->getPath();
    }
}