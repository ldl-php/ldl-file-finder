<?php
namespace LDL\FS\Type;

use \LDL\Type\Exception\TypeMismatchException;
use \LDL\Type\Collection\Types\Object\ObjectCollection;

class FileCollection extends ObjectCollection
{

    public function validateItem($item) : void
    {
        parent::validateItem($item);

        if($item instanceof \SplFileInfo){
            return;
        }

        $msg = sprintf(
            'Expected value must be an instance of \SplFileInfo, instance of "%s" was given',
            get_class($item)
        );
        throw new TypeMismatchException($msg);
    }

}