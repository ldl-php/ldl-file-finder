<?php declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use LDL\FS\Finder\Adapter\Type\Local\Facade\LocalFileFinderFacade;
use LDL\FS\Finder\Adapter\Type\Local\Validator\LocalFileHasRegexContentValidator;
use LDL\FS\Finder\FoundFile;
use LDL\FS\Finder\Validator\HasValidatorResultInterface;
use LDL\FS\Finder\Adapter\Type\Local\Validator\LocalFileSizeValidator;
use LDL\FS\Finder\Adapter\Type\Local\Validator\Config\LocalFileSizeValidatorConfig;
use LDL\FS\Finder\Adapter\Type\Local\Validator\LocalFileTypeValidator;
use LDL\FS\Finder\Adapter\Type\Local\Validator\Config\LocalFileTypeValidatorConfig;
use LDL\Validators\Chain\ValidatorChainInterface;
use LDL\Validators\ValidatorInterface;

try{

    echo "[ Find ]\n";

    if(!isset($_SERVER['argv'][1], $_SERVER['argv'][2])){
        die(sprintf('Usage: %s <dir1, dir2> <regex>%s', basename(__FILE__), "\n\n"));
    }

    $files = explode(',', $_SERVER['argv'][1]);
    $match = $_SERVER['argv'][2];

    $start = hrtime(true);
    $r = LocalFileFinderFacade::findResult(
        $files,
        [
            //new RegexValidator("/\.php/", true),
            new LocalFileTypeValidator([LocalFileTypeValidatorConfig::FILE_TYPE_REGULAR]),
            new LocalFileSizeValidator(1000000, LocalFileSizeValidatorConfig::OPERATOR_LTE, true),
            new LocalFileHasRegexContentValidator($match, true)
        ],
        [
          static function (string $path){
            dump('Accept:', $path);
          }
        ],
        [
            static function (string $path, ValidatorChainInterface $validatorChain){
                dump('Reject:', $path);
                dump("Failed validators:");
                foreach($validatorChain->getFailed() as $validator){
                    echo get_class($validator)."\n";
                }
            }
        ],
        [
            static function ($path){
                dump('File:', $path);
            }
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

    $end = hrtime(true);

    echo sprintf('Search took: %s milliseconds %s', ($end-$start)/1e+6,"\n\n");
}catch(\Exception $e) {

    echo "[ Finder failed! ]\n";
    var_dump($e);

}

