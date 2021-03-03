<?php declare(strict_types=1);

namespace LDL\FS\Finder\Adapter\Type\Local;

use LDL\FS\Finder\Adapter\AdapterInterface;
use LDL\FS\Finder\Collection\LocalDirectoryCollection;
use LDL\FS\Finder\FoundFile;
use LDL\FS\Finder\Validator\HasValidatorResultInterface;
use LDL\Validators\Chain\ValidatorChain;
use LDL\Validators\Chain\ValidatorChainInterface;

class LocalFileFinderAdapter implements AdapterInterface
{
    /**
     * @var ValidatorChain
     */
    private $validators;

    public function __construct(ValidatorChainInterface $validatorChain = null)
    {
        $this->validators = $validatorChain ?? new ValidatorChain();
    }

    public function find(iterable $directories): iterable
    {
        foreach($directories as $dir){
            foreach (new \DirectoryIterator($dir) as $file) {
                $path = $file->getRealPath();

                if($file->isDot()){
                    continue;
                }

                if($file->isDir()){
                    yield from $this->find(new LocalDirectoryCollection([$path]));
                    continue;
                }

                try{
                    $this->validators->validate($path);

                    $foundFile = new FoundFile(
                        $path,
                        $file,
                        $this->validators->filterByInterface(HasValidatorResultInterface::class)
                    );

                    yield $foundFile;
                }catch(\Exception $e){
                    continue;
                }
            }
        }
    }

    public function getValidatorChain(): ValidatorChainInterface
    {
        return $this->validators;
    }

}