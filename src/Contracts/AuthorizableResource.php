<?php

namespace Drewlabs\Storage\Contracts;

interface AuthorizableResource
{
    /**
     * Returns true if the file is publicly accessible. If the file is
     * publicly accessible users does not require authorizations to access
     * it.
     * 
     * @return bool 
     */
    public function isPublic();

    /**
     * Get the list of policy defines on the file resource
     * 
     * @return string[]|object[]
     */
    public function getPolicies();
}