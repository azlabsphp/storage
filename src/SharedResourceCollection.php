<?php

namespace Drewlabs\Storage;

use Drewlabs\Core\Helpers\Arr;
use Drewlabs\Storage\PathResourceValue;
use Drewlabs\Storage\Contracts\SharedResource;
use Drewlabs\Storage\Traits\JsonSerializable as TraitsJsonSerializable;
use JsonSerializable;

class SharedResourceCollection implements JsonSerializable
{
    use TraitsJsonSerializable;
    /**
     * 
     * @var \Iterator|\iterable
     */
    private $items;

    /**
     * 
     * @param Resource[] $items 
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
        $fn = function () use ($items) {
            foreach ($items as $value) {
                if ($value instanceof SharedResource) {
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
        $fn = function ($source) {
            /**
             * @var SharedResource $value
             */
            foreach ($source as $value) {
                yield PathResourceValue::createFromSharedResource($value);
            }
        };
        return Arr::create($fn($this->items));
    }
}
