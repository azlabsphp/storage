<?php

namespace Drewlabs\Storage;

use Drewlabs\Storage\Contracts\FileSystem as FilesystemInterface;

/**
 * @property FileSystemInterface $local
 * @property FileSystemInterface $s3
 */
class FileSystemDiskResolver
{
    /**
     * Resolve the {@see FileSystem} disk interface to use
     * @param string $name 
     * @return Filesystem 
     */
    public function __get(string $name)
    {
        return new Filesystem($name);
    }
}
