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

use Drewlabs\Core\Helpers\UUID;
use Drewlabs\Core\Helpers\Str;

/**
 * @deprecated v0.2.0 Deprecated for unused reason
 * 
 * @package Drewlabs\Storage
 */
class Random
{
    /**
     * Generate a new filename using the uuid algorithm
     *
     * @param string $extension
     * @return string
     */
    public static function filename(string $extension)
    {
        return sprintf("%s.%s", \strtolower(UUID::ordered()), $extension);
    }


    /**
     * Generate a folder basepath string
     *
     * @param string $basename
     */
    public static function foldername(string $basename)
    {
        return sprintf(
            "%s%s",
            strval(time()),
            Str::snakeCase($basename, '-')
        );
    }
}
