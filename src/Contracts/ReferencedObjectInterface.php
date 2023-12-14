<?php

namespace Drewlabs\Storage\Contracts;

interface ReferencedObjectInterface
{
    /**
     * Returns the object unique reference
     * 
     * @return string 
     */
    public function getReference();
}