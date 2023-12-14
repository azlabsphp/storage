<?php

namespace Drewlabs\Storage\Contracts;

interface SharedResource extends FileResource
{
    /**
     * Returns the client|user with whom the resource is shared
     * 
     * @return string|int 
     */
    public function sharedWith();

    /**
     * Returns the client|user who shared the resource
     * 
     * @return string|int 
     */
    public function sharedBy();

    /**
     * Returns the ISO date string at which the resource was shared
     * 
     * @return string|int 
     */
    public function sharedAt();
}