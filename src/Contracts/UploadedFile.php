<?php

namespace Drewlabs\Storage\Contracts;

interface UploadedFile
{
    /**
     * Get the content of the file as bunary string
     * 
     * @return PathResource|string 
     */
    public function getContent();

    /**
     * Get the size of the actual file
     * 
     * @return int 
     */
    public function getSize();

    /**
     * Get the extension of the actual file
     * 
     * @return string 
     */
    public function getExtension();

    /**
     * Returns the mime type of the actual file
     * 
     * @return string 
     */
    public function getMimeType();

}