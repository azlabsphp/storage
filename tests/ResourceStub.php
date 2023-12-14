<?php

namespace Drewlabs\Storage\Tests;

use Drewlabs\Core\Helpers\Str;
use Drewlabs\Core\Helpers\UUID;
use Drewlabs\Storage\Contracts\PathResource;

use function Drewlabs\Filesystem\Proxy\Path;

class ResourceStub implements PathResource
{
    /**
     * 
     * @var string
     */
    private $name;

    public function __construct()
    {
        $this->name = Str::md5();
    }

    public function __toString()
    {
        return (string)(Path(__DIR__ . '/Resources')->canonicalize());
    }

    public function modifiedAt()
    {
        return date('c');
    }

    public function createdAt()
    {
        $date = new \DateTimeImmutable;
        $timestamp = $date->sub(new \DateInterval('P1D'))->getTimestamp();
        return date(\DateTimeImmutable::ISO8601, $timestamp);
    }

    public function id()
    {
        return UUID::create();
    }

    public function name()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return 'Users profiles folders';
    }

    public function getURL()
    {
        return "http://127.0.0.1:9000/resources/" . $this->name;
    }

    public function isDirectory()
    {
        return true;
    }
}
