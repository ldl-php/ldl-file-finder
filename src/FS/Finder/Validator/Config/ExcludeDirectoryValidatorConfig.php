<?php declare(strict_types=1);

namespace LDL\FS\Finder\Validator\Config;

use LDL\Framework\Base\Contracts\ArrayFactoryInterface;
use LDL\Framework\Base\Exception\ArrayFactoryException;
use LDL\Framework\Helper\IterableHelper;
use LDL\Validators\Config\ValidatorConfigInterface;
use LDL\Validators\Config\ValidatorConfigInterfaceTrait;

class ExcludeDirectoryValidatorConfig implements ValidatorConfigInterface
{
    use ValidatorConfigInterfaceTrait;

    /**
     * @var iterable
     */
    private $directories;

    public function __construct(iterable $directories, bool $strict=true)
    {
        if(0 === IterableHelper::getCount($directories)){
            throw new \InvalidArgumentException('There must be at least one directory to exclude');
        }

        $this->directories = $directories;
        $this->_isStrict = $strict;
    }

    public function getDirectories(): iterable
    {
        return $this->directories;
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
        if(false === array_key_exists('directories', $data)){
            $msg = sprintf("Missing property 'directories' in %s", __CLASS__);
            throw new ArrayFactoryException($msg);
        }

        try{
            return new self($data['directories'], array_key_exists('strict', $data) ? (bool)$data['strict'] : true);
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
            'directories' => $this->directories,
            'strict' => $this->_isStrict
        ];
    }
}