<?php

namespace Drewlabs\Storage\Contracts;

interface PathResource
{
    /**
     * Returns string representation of object
     * 
     * @return string 
     */
    public function __toString();

    /**
     * Retuns the ISO date string representation of when the directory was last modified 
     * 
     * @return string 
     */
    public function modifiedAt();

    /**
     * Retuns the ISO date string representation of when the directory was created 
     * 
     * @return string
     */
    public function createdAt();

    /**
     * Returns the unique identifier for the object
     * 
     * @return string|int 
     */
    public function id();


    /**
     * Returns the base name of the directory
     * 
     * @return string 
     */
    public function name();

    /**
     * User provided description of the directory
     * 
     * @return string 
     */
    public function getDescription();

    /**
     * Returns the URL to the resource
     * 
     * @return string 
     */
    public function getURL();

    /**
     * Returns true if the resource is a directory or not
     * 
     * @return string 
     */
    public function isDirectory();
}
