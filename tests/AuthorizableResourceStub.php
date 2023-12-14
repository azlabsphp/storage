<?php

namespace Drewlabs\Storage\Tests;

use Drewlabs\Storage\Contracts\AuthorizableResource;

class AuthorizableResourceStub extends FileResourceStub implements AuthorizableResource
{

    public function isPublic()
    {
        return false;
    }

    public function getPolicies()
    {
        return [
            'storage:resource:get',
            'storage:resource:create',
        ];
    }
}
