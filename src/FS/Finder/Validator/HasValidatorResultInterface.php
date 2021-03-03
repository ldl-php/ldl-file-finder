<?php declare(strict_types=1);

namespace LDL\FS\Finder\Validator;

interface HasValidatorResultInterface
{
    /**
     * @return mixed
     */
    public function getResult();
}