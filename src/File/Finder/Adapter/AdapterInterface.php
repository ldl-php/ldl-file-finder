<?php declare(strict_types=1);

namespace LDL\File\Finder\Adapter;

use LDL\Framework\Base\Collection\CallableCollection;
use LDL\Validators\Chain\ValidatorChainInterface;

interface AdapterInterface
{
    /**
     * @param iterable $locations
     * @return iterable
     */
    public function find(iterable $locations): iterable;

    /**
     * Obtains the chain of validators
     *
     * @return null|ValidatorChainInterface
     */
    public function getValidatorChain(): ?ValidatorChainInterface;


    /**
     * As soon as a file is matched, regardless of the validations, the file will be sent
     * to this callable collection.
     *
     * @return CallableCollection
     */
    public function onFile() : CallableCollection;

    /**
     * When a file is invalid, this set of callbacks will be called, the anonymous functions
     * added to this callback collection must take two arguments:
     *
     *  $path: string (URI of the file)
     *  $validators: ValidatorChainInterface (current chain of validators)
     *
     * @return CallableCollection
     */
    public function onReject() : CallableCollection;

    /**
     * When a file is valid, this set of callbacks will be called, the anonymous functions
     * added to this callback collection must take two arguments:
     *
     *  $path: string (URI of the file)
     *  $validators: ValidatorChainInterface (current chain of validators)
     *
     * @return CallableCollection
     */
    public function onAccept() : CallableCollection;

    /**
     * @return int
     */
    public function getTotalFileCount() : int;
}
