<?php declare(strict_types=1);

namespace LDL\FS\Finder;

use LDL\FS\Finder\Adapter\AdapterInterface;
use LDL\FS\Finder\Adapter\Collection\AdapterCollection;

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
