<?php declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use LDL\FS\Finder\Adapter\Type\Local\Facade\LocalFileFinderFacade;
use LDL\FS\Finder\Validator\ExcludeDirectoryValidator;
use LDL\FS\Finder\Collection\LocalDirectoryCollection;
use LDL\Validators\RegexValidator;
use LDL\FS\Finder\Adapter\Type\Local\Validator\LocalFileHasRegexContentValidator;
use LDL\FS\Finder\FoundFile;
use LDL\FS\Finder\Validator\HasValidatorResultInterface;

try{
    echo "[ Find ]\n";

    $r = LocalFileFinderFacade::findResult(
        [__DIR__.'/../'],
        [
            new ExcludeDirectoryValidator(
                new LocalDirectoryCollection([__DIR__ . '/../vendor', __DIR__.'/../.git'])
            ),
            new RegexValidator("/\.php/", true),
            new LocalFileHasRegexContentValidator('/match-me-only/', true)
        ]
    );

    /**
     * @var FoundFile $f
     */
    foreach($r as $f){
        echo "File: $f\n";
        /**
         * @var HasValidatorResultInterface $v
         */
        foreach($f->getValidatorChain() as $v){
            var_dump($v->getResult());
        }
    }
}catch(\Exception $e) {

    echo "[ Finder failed! ]\n";
    var_dump($e);

}

