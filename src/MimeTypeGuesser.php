<?php

namespace Drewlabs\Storage;

use Drewlabs\DataURI\MimesExtensions;
use Drewlabs\Storage\Contracts\MimeTypeGuesser as MimeTypeGuesserInterface;
use LogicException;
use Symfony\Component\Mime\MimeTypes;

/** @package Drewlabs\Storage */
class MimeTypeGuesser implements MimeTypeGuesserInterface
{

    public static function gessMimeTypeFromPath(string $path)
    {
        if (!class_exists(MimeTypes::class)) {
            throw new LogicException('symfony/mimes package is required to use this function');
        }
        return MimeTypes::getDefault()->guessMimeType($path);
    }

    public function gessMimeType(string $extension)
    {
        return MimesExtensions::getMimeType($extension);
    }

    public function gessExtension(string $mime)
    {
        if (!class_exists(MimeTypes::class)) {
            return MimesExtensions::getExtension($mime);
        }
        return MimeTypes::getDefault()->getExtensions($mime)[0] ?? null;
    }
}
