<?php


namespace Drewlabs\Storage\Proxy;

use Drewlabs\Storage\Filesystem;
use Drewlabs\Storage\FileSystemDiskResolver;
use Drewlabs\Storage\PathResourceValue;
use Drewlabs\Storage\Contracts\AuthorizableResource;
use Drewlabs\Storage\Contracts\FileResource;
use Drewlabs\Storage\Contracts\SharedResource;
use Drewlabs\Storage\Contracts\PathResource;

/**
 * Proxy method to Filesystem class constructor
 * 
 * @param string|null $disk 
 * @return Filesystem 
 */
function Storage(string $disk = null)
{
    if (is_string($disk)) {
        return new FileSystem($disk);
    }
    return new Filesystem();
}

/**
 * Create a closure which redirect calls to {@see FileSystem} class
 * 
 * @return FileSystemDiskResolver
 */
function useStorage()
{
    return new FileSystemDiskResolver();
}

/**
 * Create a jsonable instance of storage object instance
 * 
 * @param AuthorizableResource|FileResource|SharedResource|PathResource $value 
 * @return PathResourceValue 
 */
function StorageObjectValue($value)
{
    return PathResourceValue::create($value);
}