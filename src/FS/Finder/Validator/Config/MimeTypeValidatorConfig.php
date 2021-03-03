<?php declare(strict_types=1);

namespace LDL\FS\Finder\Validator\Config;

use LDL\Framework\Base\Contracts\ArrayFactoryInterface;
use LDL\Framework\Base\Exception\ArrayFactoryException;
use LDL\Type\Collection\Types\String\StringCollection;
use LDL\Validators\Config\ValidatorConfigInterface;
use LDL\Validators\Config\ValidatorConfigInterfaceTrait;

class MimeTypeValidatorConfig implements ValidatorConfigInterface
{
    use ValidatorConfigInterfaceTrait;

    /**
     * @var StringCollection
     */
    private $types;

    public function __construct($types, bool $strict = true)
    {
        if(count($types) === 0){
            throw new \InvalidArgumentException("The collection must have at least one mime type");
        }

        $this->types = new StringCollection($types);
        $this->_isStrict = $strict;
    }

    public function getTypes(): StringCollection
    {
        return $this->types;
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
        if(false === array_key_exists('types', $data)){
            $msg = sprintf("Missing property 'types' in %s", __CLASS__);
            throw new ArrayFactoryException($msg);
        }

        try{
            return new self($data['types'], array_key_exists('strict', $data) ? (bool)$data['strict'] : true);
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
            'types' => $this->types->toArray(),
            'strict' => $this->_isStrict
        ];
    }
}