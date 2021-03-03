<?php declare(strict_types=1);

namespace LDL\FS\Finder\Validator;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\FS\Finder\Validator\Config\ExcludeDirectoryValidatorConfig;
use LDL\Validators\Config\ValidatorConfigInterface;
use LDL\Validators\HasValidatorConfigInterface;
use LDL\Validators\ValidatorInterface;

class ExcludeDirectoryValidator implements ValidatorInterface, HasValidatorConfigInterface
{
    /**
     * @var ExcludeDirectoryValidatorConfig
     */
    private $config;

    public function __construct(iterable $directories, bool $strict=true)
    {
        $this->config = new ExcludeDirectoryValidatorConfig($directories, $strict);
    }

    /**
     * @param string $path
     * @param null $key
     * @param CollectionInterface|null $collection
     * @throws \LogicException
     */
    public function validate($path, $key = null, CollectionInterface $collection = null): void
    {
        foreach($this->config->getDirectories() as $excluded){
            if(false !== strpos($path, $excluded)){
                throw new \LogicException('Excluded directory match');
            }
        }
    }

    /**
     * @param ValidatorConfigInterface $config
     * @return ValidatorInterface
     * @throws \InvalidArgumentException
     */
    public static function fromConfig(ValidatorConfigInterface $config): ValidatorInterface
    {
        if(false === $config instanceof ExcludeDirectoryValidatorConfig){
            $msg = sprintf(
                'Config expected to be %s, config of class %s was given',
                __CLASS__,
                get_class($config)
            );
            throw new \InvalidArgumentException($msg);
        }

        /**
         * @var ExcludeDirectoryValidatorConfig $config
         */
        return new self($config->getDirectories(), $config->isStrict());
    }

    /**
     * @return ExcludeDirectoryValidatorConfig
     */
    public function getConfig(): ExcludeDirectoryValidatorConfig
    {
        return $this->config;
    }
}