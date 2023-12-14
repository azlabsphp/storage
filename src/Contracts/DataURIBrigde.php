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

use Drewlabs\DataURI\Contracts\DataURI;

interface DataURIBrigde
{
    /**
     * Handler method for creating a data URI object.
     *
     * @param string      $content
     * @param string|null $extension
     *
     * @return DataURI
     */
    public function create(string $content, $extension = null);

    /**
     * Handler method for creating a list data URI object.
     *
     * @return DataURI[]
     */
    public function createArray(array $attributes);
}
