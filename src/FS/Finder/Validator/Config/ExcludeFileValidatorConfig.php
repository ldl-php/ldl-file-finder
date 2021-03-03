<?php declare(strict_types=1);

namespace LDL\FS\Finder\Validator\Config;

use LDL\Framework\Base\Contracts\ArrayFactoryInterface;
use LDL\Framework\Base\Exception\ArrayFactoryException;
use LDL\Type\Collection\Types\String\UniqueStringCollection;
use LDL\Validators\Config\ValidatorConfigInterface;
use LDL\Validators\Config\ValidatorConfigInterfaceTrait;

class ExcludeFileValidatorConfig implements ValidatorConfigInterface
{
    use ValidatorConfigInterfaceTrait;

    /**
     * @var UniqueStringCollection
     */
    private $files;

    public function __construct($files, bool $strict=true)
    {
        if(count($files) === 0){
            throw new \InvalidArgumentException("The collection must have at least one file to exclude");
        }

        $this->files = new UniqueStringCollection($files);
        $this->_isStrict = $strict;
    }

    public function getFiles(): UniqueStringCollection
    {
        return $this->files;
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
        if(false === array_key_exists('files', $data)){
            $msg = sprintf("Missing property 'files' in %s", __CLASS__);
            throw new ArrayFactoryException($msg);
        }

        try{
            return new self($data['files'], array_key_exists('strict', $data) ? (bool)$data['strict'] : true);
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
            'files' => $this->files,
            'strict' => $this->_isStrict
        ];
    }
}