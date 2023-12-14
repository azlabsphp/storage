<?php


namespace Drewlabs\Storage\Contracts;

interface MimeTypeGuesser
{
    /**
     * Returns the mimetype of a given stream/file resource
     * knowing it extension
     * 
     * @param string $extension 
     * @return string 
     */
    public function gessMimeType(string $extension);

    /**
     * Returns the extension of a given stream/file resource
     * knowing it mime type
     * 
     * @param string $mime 
     * @return string 
     */
    public function gessExtension(string $mime);
}