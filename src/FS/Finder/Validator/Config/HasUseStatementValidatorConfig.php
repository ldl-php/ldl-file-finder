<?php declare(strict_types=1);

namespace LDL\FS\Finder\Validator\Config;

use LDL\Framework\Base\Contracts\ArrayFactoryInterface;
use LDL\Framework\Base\Exception\ArrayFactoryException;
use LDL\Type\Collection\Types\String\UniqueStringCollection;
use LDL\Validators\Config\ValidatorConfigInterface;
use LDL\Validators\Config\ValidatorConfigInterfaceTrait;

class HasUseStatementValidatorConfig implements ValidatorConfigInterface
{
    use ValidatorConfigInterfaceTrait;

    /**
     * @var UniqueStringCollection
     */
    private $classes;

    public function __construct($classes, bool $strict = true)
    {
        if(count($classes) === 0){
            throw new \InvalidArgumentException("The collection must have at least one class");
        }

        $this->classes = new UniqueStringCollection($classes);
        $this->_isStrict = $strict;
    }

    public function getClasses(): UniqueStringCollection
    {
        return $this->classes;
    }

    /**
     * @return array
     */
    public function jsonSerialize() : array
    {
        return $this->toArray();
    }

    /**
     * @param array $data
     * @return ArrayFactoryInterface
     * @throws ArrayFactoryException
     */
    public static function fromArray(array $data = []): ArrayFactoryInterface
    {
        if(false === array_key_exists('classes', $data)){
            $msg = sprintf("Missing property 'classes' in %s", __CLASS__);
            throw new ArrayFactoryException($msg);
        }

        try{
            return new self($data['classes'], array_key_exists('strict', $data) ? (bool)$data['strict'] : true);
        }catch(\Exception $e){
            throw new ArrayFactoryException($e->getMessage());
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'classes' => $this->classes->toArray(),
            'strict' => $this->_isStrict
        ];
    }
}