<?php

namespace Drewlabs\Storage\Tests;

use Drewlabs\Core\Helpers\Str;
use Drewlabs\Core\Helpers\UUID;
use Drewlabs\Storage\Contracts\FileResource;
use Drewlabs\Storage\Contracts\ReferencedObjectInterface;
use Drewlabs\Storage\UploadedFile;

use function Drewlabs\Filesystem\Proxy\Path;

class FileResourceStub implements FileResource, ReferencedObjectInterface
{
    /**
     * 
     * @var UploadedFile
     */
    private $file;

    /**
     * 
     * @var string
     */
    private $path;

    /**
     * 
     * @var string
     */
    private $name;

    /**
     * 
     * @var string
     */
    private $reference;

    public function __construct()
    {
        $this->path = (string)(Path(__DIR__ . '/Resources/photo.png'))->canonicalize();
        $this->file = new UploadedFile(new \SplFileInfo($this->path));
        $this->name = Str::md5();
        $this->reference = sprintf("REF%s", Str::rand(10, true));
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function name()
    {
        return $this->name;
    }

    public function getSize()
    {
        return $this->file->getSize();
    }

    public function getExtension()
    {
        return $this->file->getExtension();
    }

    public function getMimeType()
    {
        return $this->file->getMimeType();
    }

    public function __toString()
    {
        return $this->path;
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

    public function getDescription()
    {
        return 'Description...';
    }

    public function getURL()
    {
        return "http://127.0.0.1:9000/resources/" . $this->name;
    }

    public function isDirectory()
    {
        return false;
    }
}
