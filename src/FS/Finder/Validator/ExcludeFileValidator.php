<?php declare(strict_types=1);

namespace LDL\FS\Finder\Validator;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\FS\Finder\Validator\Config\ExcludeFileValidatorConfig;
use LDL\Validators\Config\ValidatorConfigInterface;
use LDL\Validators\HasValidatorConfigInterface;
use LDL\Validators\ValidatorInterface;

class ExcludeFileValidator implements ValidatorInterface, HasValidatorConfigInterface
{
    /**
     * @var ExcludeFileValidatorConfig
     */
    private $config;

    public function __construct($files, bool $strict=true)
    {
        $this->config = new ExcludeFileValidatorConfig($files, $strict);
    }

    /**
     * @param mixed $item
     * @param null $key
     * @param CollectionInterface|null $collection
     * @throws \LogicException
     */
    public function validate($item, $key = null, CollectionInterface $collection = null): void
    {
        if(false === in_array($item->getPath(), $this->config->getFiles()->toArray(), true)){
            return;
        }

        throw new \LogicException('Excluded file match');
    }

    /**
     * @param ValidatorConfigInterface $config
     * @return ValidatorInterface
     * @throws \InvalidArgumentException
     */
    public static function fromConfig(ValidatorConfigInterface $config): ValidatorInterface
    {
        if(false === $config instanceof ExcludeFileValidatorConfig){
            $msg = sprintf(
                'Config expected to be %s, config of class %s was given',
                __CLASS__,
                get_class($config)
            );
            throw new \InvalidArgumentException($msg);
        }

        /**
         * @var ExcludeFileValidatorConfig $config
         */
        return new self($config->getFiles(), $config->isStrict());
    }

    /**
     * @return ExcludeFileValidatorConfig
     */
    public function getConfig(): ExcludeFileValidatorConfig
    {
        return $this->config;
    }
}