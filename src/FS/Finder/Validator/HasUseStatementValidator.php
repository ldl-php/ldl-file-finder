<?php declare(strict_types=1);

namespace LDL\FS\Finder\Validator;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\FS\Finder\Validator\Config\HasUseStatementValidatorConfig;
use LDL\Type\Collection\Types\String\StringCollection;
use LDL\Validators\Config\ValidatorConfigInterface;
use LDL\Validators\HasValidatorConfigInterface;
use LDL\Validators\ValidatorInterface;

class HasUseStatementValidator implements ValidatorInterface, HasValidatorConfigInterface, HasValidatorResultInterface
{
    private const PHP_MIME_TYPE = 'text/x-php';

    /**
     * @var HasUseStatementValidatorConfig
     */
    private $config;

    public function __construct($classes, bool $strict = true)
    {
        $this->config = new HasUseStatementValidatorConfig($classes, $strict);
    }

    /**
     * @param string $path
     * @param null $key
     * @param CollectionInterface|null $collection
     * @throws \LogicException
     */
    public function validate($path, $key = null, CollectionInterface $collection = null): void
    {
        if(mime_content_type($path) !== self::PHP_MIME_TYPE){
            throw new \LogicException('Not a PHP file');
        }

        $tokens = token_get_all(file_get_contents($path));
        $insideUseStatement = false;

        $ns = new StringCollection();

        foreach ($tokens as $k=>$token) {
            if (!is_array($token)) {
                continue;
            }

            if ($token[0] === \T_USE) {
                $insideUseStatement = true;
                continue;
            }

            if (true === $insideUseStatement && (' ' === $token[1] || \T_NS_SEPARATOR === $token[0])) {
                continue;
            }

            if(true === $insideUseStatement && \T_STRING === $token[0]){
                $ns->append($token[1]);
                continue;
            }


            if (true === $insideUseStatement && \T_WHITESPACE === $token[0]) {
                $insideUseStatement=false;

                if($this->config->getClasses()->hasValue($ns->implode('\\'))){
                    return;
                }

            }
        }

        throw new \LogicException('a');
    }

    public function getResult()
    {
        return [1,2,3];
    }

    /**
     * @param ValidatorConfigInterface $config
     * @return ValidatorInterface
     * @throws \InvalidArgumentException
     */
    public static function fromConfig(ValidatorConfigInterface $config): ValidatorInterface
    {
        if(false === $config instanceof HasUseStatementValidatorConfig){
            $msg = sprintf(
                'Config expected to be %s, config of class %s was given',
                __CLASS__,
                get_class($config)
            );
            throw new \InvalidArgumentException($msg);
        }

        /**
         * @var HasUseStatementValidatorConfig $config
         */
        return new self($config->getClasses(), $config->isStrict());
    }

    /**
     * @return HasUseStatementValidatorConfig
     */
    public function getConfig(): HasUseStatementValidatorConfig
    {
        return $this->config;
    }
}