<?php

namespace LDL\FS\Finder\Adapter;

use LDL\FS\Finder\Interfaces\AdapterInterface;

use LDL\FS\Type\Types\Generic\Collection\GenericFileCollection;

use LDL\FS\Type\Types\Generic\GenericFileType;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo as FileInfo;

class LocalFileFinder implements AdapterInterface
{
    /**
     * {@inheritdoc}
     */
    public static function find(
        array $directories,
        array $files,
        bool $includeDotFiles = false
    ): GenericFileCollection
    {
        $finder = new Finder();

        $finder->ignoreDotFiles(!$includeDotFiles);

        $finder->filter(static function (FileInfo $file){
            return !(true === $file->isDir());
        })
        ->filter(static function (FileInfo $file) use($files) {
            return in_array($file->getFilename(), $files, true);
        })
        ->in($directories);

        $collection = new GenericFileCollection();

        foreach($finder as $file){
            $collection->append(new GenericFileType($file->getRealPath()));
        }

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public static function findRegex(string $regex, array $directories): GenericFileCollection
    {
        $finder = new Finder();

        $finder->filter(static function (FileInfo $file) use ($regex) {
            if ($file->isDir()) {
                return false;
            }

            return (bool) preg_match("#$regex#", $file->getFilename());
        })
        ->in($directories);

        $collection = new GenericFileCollection();

        foreach($finder as $file){
            $collection->append(new GenericFileType($file->getRealPath()));
        }

        return $collection;
    }

    public static function findMatching(string $match, array $directories) : GenericFileCollection
    {
        $finder = new Finder();

        $finder->filter(static function (FileInfo $file) use ($match) {
            if ($file->isDir()) {
                return false;
            }

            return $match === $file->getFilename();
        })
        ->in($directories);

        $collection = new GenericFileCollection();

        foreach($finder as $file){
            $collection->append(new GenericFileType($file->getRealPath()));
        }

        return $collection;
    }

}
