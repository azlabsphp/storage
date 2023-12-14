<?php

namespace Drewlabs\Storage\Tests;

use Drewlabs\Storage\FileSystemPath;
use PHPUnit\Framework\TestCase;

class FileSystemPathTest extends TestCase
{

    public function test_reduce_path()
    {
       $this->assertEquals('hello/world_path_to_file', (function() {
           $path =  FileSystemPath::reduce('hello/world/path/to/file');
           return $path;
       })()); // returns hello/world_path_to/file
       $this->assertEquals('hello/path', FileSystemPath::reduce('hello/path')); // returns hello/path
       $this->assertEquals('path', FileSystemPath::reduce('path')); // returns path
    }
}