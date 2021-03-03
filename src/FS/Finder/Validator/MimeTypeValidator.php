<?php declare(strict_types=1);

namespace LDL\FS\Finder\Validator;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\FS\Finder\Validator\Config\MimeTypeValidatorConfig;
use LDL\Validators\Config\ValidatorConfigInterface;
use LDL\Validators\HasValidatorConfigInterface;
use LDL\Validators\ValidatorInterface;

class MimeTypeValidator implements ValidatorInterface, HasValidatorConfigInterface
{
    /**
     * @var MimeTypeValidatorConfig
     */
    private $config;

    public function __construct($types, bool $strict = true)
    {
        $this->config = new MimeTypeValidatorConfig($types, $strict);
    }

    /**
     * @param mixed $item
     * @param null $key
     * @param CollectionInterface|null $collection
     * @throws \LogicException
     */
    public function validate($item, $key = null, CollectionInterface $collection = null): void
    {
        if($this->config->getTypes()->hasValue(mime_content_type($item->getRealPath()))){
            return;
        }

        $msg = sprintf(
            'File: %s does not match mime types: %s',
            $item->getRealPath(),
            $this->config->gettypes()->implode()
        );

        throw new \LogicException($msg);
    }

    /**
     * @param ValidatorConfigInterface $config
     * @return ValidatorInterface
     * @throws \InvalidArgumentException
     */
    public static function fromConfig(ValidatorConfigInterface $config): ValidatorInterface
    {
        if(false === $config instanceof MimeTypeValidatorConfig){
            $msg = sprintf(
                'Config expected to be %s, config of class %s was given',
                __CLASS__,
                get_class($config)
            );
            throw new \InvalidArgumentException($msg);
        }

        /**
         * @var MimeTypeValidatorConfig $config
         */
        return new self($config->getTypes(), $config->isStrict());
    }

    /**
     * @return MimeTypeValidatorConfig
     */
    public function getConfig(): MimeTypeValidatorConfig
    {
        return $this->config;
    }
}