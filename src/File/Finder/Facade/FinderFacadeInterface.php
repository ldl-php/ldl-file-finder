<?php declare(strict_types=1);

namespace LDL\File\Finder\Facade;

use LDL\File\Finder\FinderResult;

interface FinderFacadeInterface
{
    /**
     * Find by using pure generators
     * @param iterable $locations
     * @return iterable
     */
    public static function find(iterable $locations) : iterable;

    /**
     * Find by using a FinderResult (persisted in memory) class
     * @param iterable $locations
     * @return FinderResult
     */
    public static function findResult(iterable $locations) : FinderResult;
}