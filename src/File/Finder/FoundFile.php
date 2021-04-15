<?php declare(strict_types=1);

namespace LDL\File\Finder;

use LDL\Validators\Chain\ValidatorChainInterface;

class FoundFile
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
     * @var ?ValidatorChainInterface|null
     */
    private $validators;

    public function __construct(string $path, $fileObject, ValidatorChainInterface $result = null)
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
     * @return ValidatorChainInterface|null
     */
    public function getValidatorChain(): ?ValidatorChainInterface
    {
        return $this->validators;
    }

    public function __toString()
    {
        return $this->getPath();
    }
}