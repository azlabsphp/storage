<?php

namespace Drewlabs\Storage\Traits;

trait JsonSerializable
{
    #[\ReturnTypeWillChange]
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}