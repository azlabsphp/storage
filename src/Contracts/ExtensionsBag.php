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

namespace Drewlabs\Storage\Contracts;

interface ExtensionsBag
{
    /**
     * Get list of extensions corresponding to use provided {$key} parameter.
     *
     * @param string[] $default
     *
     * @return string[]
     */
    public function get(string $key, array $default = []);
}
