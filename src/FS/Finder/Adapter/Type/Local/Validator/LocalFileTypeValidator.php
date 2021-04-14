<?php declare(strict_types=1);

namespace LDL\FS\Finder\Adapter\Type\Local\Validator;

use LDL\Validators\Config\ValidatorConfigInterface;
use LDL\Validators\HasValidatorConfigInterface;
use LDL\Validators\ValidatorInterface;

class LocalFileTypeValidator implements ValidatorInterface, HasValidatorConfigInterface
{

    /**
     * @var Config\LocalFileTypeValidatorConfig
     */
    private $config;

    /**
     *
     * The match parameter specified if the regex should be matched or not, this is useful when you want to find
     * files which DO NOT HAVE a certain string. If you set match to true, then only files which comply to the
     * regex will be shown.
     *
     * @param iterable $types
     * @param bool $match
     * @param bool $strict
     */
    public function __construct(iterable $types, bool $match=true, bool $strict = true)
    {
        $this->config = new Config\LocalFileTypeValidatorConfig($types, $match, $strict);
    }

    public function validate($value): void
    {
        $perms = fileperms($value);

        if(!$perms){
            throw new \InvalidArgumentException('Invalid file provided');
        }

        switch (fileperms($value) & 0xF000) {
            case 0xC000: // socket
                $type = Config\LocalFileTypeValidatorConfig::FILE_TYPE_SOCKET;
                break;
            case 0xA000: // symbolic link
                $type = Config\LocalFileTypeValidatorConfig::FILE_TYPE_LINK;
                break;
            case 0x8000: // regular
                $type = Config\LocalFileTypeValidatorConfig::FILE_TYPE_REGULAR;
                break;
            case 0x6000: // block special
                $type = Config\LocalFileTypeValidatorConfig::FILE_TYPE_BLOCK;
                break;
            case 0x4000: // directory
                $type = Config\LocalFileTypeValidatorConfig::FILE_TYPE_DIRECTORY;
                break;
            case 0x2000: // character special
                $type = Config\LocalFileTypeValidatorConfig::FILE_TYPE_CHAR;
                break;
            case 0x1000: // FIFO pipe
                $type = Config\LocalFileTypeValidatorConfig::FILE_TYPE_FIFO;
                break;
            default: // unknown
                $type = Config\LocalFileTypeValidatorConfig::FILE_TYPE_UNKNOWN;
        }

        if($this->config->isMatch()){
            if($this->config->getTypes()->hasValue($type)){
                return;
            }

            throw new \InvalidArgumentException('File type criteria not satisfied');
        }

        if(!$this->config->getTypes()->hasValue($type)){
            return;
        }

        throw new \InvalidArgumentException('File type criteria not satisfied');
    }

    /**
     * @param ValidatorConfigInterface $config
     * @return ValidatorInterface
     * @throws \InvalidArgumentException
     */
    public static function fromConfig(ValidatorConfigInterface $config): ValidatorInterface
    {
        if(false === $config instanceof Config\LocalFileTypeValidatorConfig){
            $msg = sprintf(
                'Config expected to be %s, config of class %s was given',
                __CLASS__,
                get_class($config)
            );
            throw new \InvalidArgumentException($msg);
        }

        /**
         * @var Config\LocalFileTypeValidatorConfig $config
         */
        return new self(
            $config->getTypes(),
            $config->isMatch(),
            $config->isStrict()
        );
    }

    /**
     * @return Config\LocalFileTypeValidatorConfig
     */
    public function getConfig(): Config\LocalFileTypeValidatorConfig
    {
        return $this->config;
    }
}