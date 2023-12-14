<?php

namespace Drewlabs\Storage;

use Drewlabs\Core\Helpers\Arr;
use Drewlabs\Storage\PathResourceValue;
use Drewlabs\Storage\Contracts\PathResource;
use Drewlabs\Storage\Traits\JsonSerializable as TraitsJsonSerializable;
use JsonSerializable;
use Drewlabs\Storage\Contracts\FileResource;
use Drewlabs\Storage\Contracts\SharedResource;

/** @package Drewlabs\Storage */
class PathResourceCollection implements JsonSerializable
{
    use TraitsJsonSerializable;
    /**
     * 
     * @var \Iterator|\iterable
     */
    private $items;

    /**
     * 
     * @param PathResource[] $items 
     * @return self 
     */
    public function __construct($items = [])
    {
        $this->createSource($items);
    }

    /**
     * 
     * @param \Iterator|\iterable|array $items 
     * @return void 
     */
    private function createSource($items)
    {
        $fn = function() use ($items) {
            foreach ($items as $value) {
                if ($value instanceof PathResource) {
                    yield $value;
                }
            }
        };
        $this->items = $fn();
    }

    public function toArray()
    {
        /**
         * @param \Iterator|\iterable $source
         */
        $fn = function($source) {
            /**
             * @var PathResource|FileResource|SharedResource $value
             */
            foreach ($source as $value) {
                yield PathResourceValue::create($value);
            }
        };
        return Arr::create($fn($this->items));
    }
}
