<?php declare(strict_types=1);

namespace LDL\FS\Finder\Validator\Config;

use LDL\Framework\Base\Contracts\ArrayFactoryInterface;
use LDL\Framework\Base\Exception\ArrayFactoryException;
use LDL\Validators\Config\ValidatorConfigInterface;
use LDL\Validators\Config\ValidatorConfigInterfaceTrait;

class FileExtensionValidatorConfig implements ValidatorConfigInterface
{
    use ValidatorConfigInterfaceTrait;

    /**
     * @var string
     */
    private $extension;

    public function __construct(string $extension, bool $strict = true)
    {
        $this->extension = $extension;
        $this->_isStrict = $strict;
    }

    public function getExtension(): string
    {
        return $this->extension;
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
        if(false === array_key_exists('extension', $data)){
            $msg = sprintf("Missing property 'extension' in %s", __CLASS__);
            throw new ArrayFactoryException($msg);
        }

        try{
            return new self((string) $data['extension'], array_key_exists('strict', $data) ? (bool)$data['strict'] : true);
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
            'extension' => $this->extension,
            'strict' => $this->_isStrict
        ];
    }
}