<?php

use Drewlabs\Storage\Extensions;
use Drewlabs\Storage\MediaTypeMapper;
use PHPUnit\Framework\TestCase;

class MediaTypeMapperTest extends TestCase
{
    public function test_get_mime_types()
    {
        $mapper = new MediaTypeMapper();
        $types = $mapper->getMimeTypes('image');
        $this->assertEquals(Extensions::IMAGES, $types['extensions']);
    }
}