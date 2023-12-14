<?php

namespace Drewlabs\Storage\Contracts;

interface FileResource extends PathResource
{
    /**
     * Returns the size of the resource object
     * 
     * @return int 
     */
    public function getSize();

    /**
     * Returns the extension of the resource
     * 
     * @return string 
     */
    public function getExtension();

    /**
     * Returns the mime type of the resource
     * 
     * @return string 
     */
    public function getMimeType();
}