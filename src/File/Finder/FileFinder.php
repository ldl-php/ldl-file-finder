<?php declare(strict_types=1);

namespace LDL\File\Finder;

use LDL\File\Finder\Adapter\AdapterInterface;
use LDL\File\Finder\Adapter\Collection\AdapterCollection;

class FileFinder implements FileFinderInterface
{
    /**
     * @var AdapterCollection
     */
    private $adapters;

    public function __construct(AdapterCollection $adapters)
    {
        $this->adapters = $adapters;
    }

    public function find(iterable $directories): iterable
    {
        /**
         * @var AdapterInterface $adapter
         */
        foreach($this->adapters as $adapter){
            yield from $adapter->find($directories);
        }
    }

}
