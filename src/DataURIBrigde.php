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

use Drewlabs\DataURI\Contracts\DataURI;
use Drewlabs\DataURI\Parser;
use Drewlabs\Storage\Contracts\DataURIBrigde as ContractsDataURIBrigde;

class DataURIBrigde implements ContractsDataURIBrigde
{
    /**
     * 
     * @var Parser
     */
    private $parser;

    public function __construct()
    {
        $this->parser = new Parser();
    }

    /**
     * Create a data uri object from a string content
     * 
     * @param string $content 
     * @param string|null $extension 
     * @return DataURI 
     */
    public function create(string $content, $extension = null)
    {
        try {
            $resource = $this->parser->parse($content);
            if ((null === $resource->getExtension()) && (null !== $extension)) {
                $resource = $resource->setExtension($extension);
            }
            return $resource;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Creates a list of data uri object from a list of string contents
     * 
     * @param array $attributes 
     * @return DataURI[] 
     */
    public function createArray(array $attributes = [])
    {
        try {
            return array_map(
                function ($attribute) {
                    return $this->create(
                        $attribute['content'],
                        $attribute['extension'] ?? null
                    );
                },
                array_filter(
                    $attributes ?? [],
                    static function ($attribute) {
                        return isset($attribute['content']);
                    }
                )
            );
        } catch (\Exception $e) {
            return [];
        }
    }
}
