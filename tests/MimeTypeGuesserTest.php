<?php

use Drewlabs\Storage\MimeTypeGuesser;
use PHPUnit\Framework\TestCase;

class MimeTypeGuesserTest extends TestCase
{
    public function test_gess_mime_type()
    {
        $guesser = new MimeTypeGuesser;
        $extension = $guesser->gessMimeType('3gp');
        $this->assertEquals('video/3gpp', $extension);
    }

    public function test_gess_extension()
    {
        $guesser = new MimeTypeGuesser;
        $extension = $guesser->gessExtension('application/pdf');
        $this->assertEquals('pdf', $extension);
    }

    public function test_gess_mime_type_from_path_throws_exception()
    {
        $this->expectException(LogicException::class);
        MimeTypeGuesser::gessMimeTypeFromPath(__DIR__.'/Resources/photo.png');
    }
}