<?php

declare(strict_types=1);

/*
 * This file is part of the Drewlabs package.
 *
 * (c) Sidoine Azandrew <azandrewdevelopper@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Drewlabs\Storage;

use Drewlabs\Core\Helpers\Str;
use RuntimeException;

/**
 * @deprecated v0.2.0 Deprecated for unused reason
 * 
 * @package Drewlabs\Storage
 */
class FileSystemPath
{
    /**
     * Combine the folder path with the file name returning the file full path
     *
     * @param string[] $paths
     * @return string
     */
    public static function join(array $paths = [])
    {
        if (empty($paths)) {
            return DIRECTORY_SEPARATOR;
        }
        $paths = array_map(function ($item) {
            return Str::rtrim($item, DIRECTORY_SEPARATOR);
        }, $paths);
        return Str::concat(DIRECTORY_SEPARATOR, ...$paths);
    }

    /**
     * This function will try to reduce depth of path by seperating subdirectory with _
     * 
     * Examples:
     * 
     * ```php
     * PathUtilities::reduce('hello/world/path/to/file'); // returns hello/world_path_to_file
     * PathUtilities::reduce('hello/path'); // returns hello/path
     * PathUtilities::reduce('path'); // returns path
     * 
     * ```
     * @param string $path 
     * @return string 
     * @throws RuntimeException 
     */
    public static function reduce(string $path)
    {
        if (Str::contains($path, DIRECTORY_SEPARATOR)) {
            // TODO: Get the base folder
            $basePath = Str::before(DIRECTORY_SEPARATOR, $path);
            // TODO: Get the filename
            $subPath = Str::replace(DIRECTORY_SEPARATOR, '_', Str::after(DIRECTORY_SEPARATOR, $path));
            $parts = array_filter([$basePath, $subPath]);
            return Str::join($parts, DIRECTORY_SEPARATOR);
        }
        return $path;
    }
}
