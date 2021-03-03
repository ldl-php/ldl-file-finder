<?php declare(strict_types=1);

namespace LDL\FS\Finder\Validator;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\FS\Finder\Validator\Config\FileExtensionValidatorConfig;
use LDL\Validators\Config\ValidatorConfigInterface;
use LDL\Validators\HasValidatorConfigInterface;
use LDL\Validators\ValidatorInterface;

class FileExtensionValidator implements ValidatorInterface, HasValidatorConfigInterface
{
    /**
     * @var FileExtensionValidatorConfig
     */
    private $config;

    public function __construct(string $extension, bool $strict = true)
    {
        $this->config = new FileExtensionValidatorConfig($extension, $strict);
    }

    /**
     * @param mixed $item
     * @param null $key
     * @param CollectionInterface|null $collection
     * @throws \LogicException
     */
    public function validate($item, $key = null, CollectionInterface $collection = null): void
    {
        if($item->getExtension() === $this->config->getExtension()){
            return;
        }

        throw new \LogicException('Extension does not match');
    }

    /**
     * @param ValidatorConfigInterface $config
     * @return ValidatorInterface
     * @throws \InvalidArgumentException
     */
    public static function fromConfig(ValidatorConfigInterface $config): ValidatorInterface
    {
        if(false === $config instanceof FileExtensionValidatorConfig){
            $msg = sprintf(
                'Config expected to be %s, config of class %s was given',
                __CLASS__,
                get_class($config)
            );
            throw new \InvalidArgumentException($msg);
        }

        /**
         * @var FileExtensionValidatorConfig $config
         */
        return new self($config->getExtension(), $config->isStrict());
    }

    /**
     * @return FileExtensionValidatorConfig
     */
    public function getConfig(): FileExtensionValidatorConfig
    {
        return $this->config;
    }
}