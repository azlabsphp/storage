<?php

declare(strict_types=1);

/*
 * This file is part of the Drewlabs package.
 *
 * (c) Sidoine Azandrew <azandrewdevelopper@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Drewlabs\Storage;

use Drewlabs\DataURI\MimesExtensions;
use Drewlabs\Storage\Contracts\ExtensionsBag;

final class MediaTypeMapper
{
    /**
     * @var ExtensionsBag|null
     */
    private $extensionsBag;

    public function __construct(?ExtensionsBag $extensionsBag = null)
    {
        $this->extensionsBag = $extensionsBag;
    }

    public function getMimeTypes(string $type = 'image')
    {
        switch (strtolower($type)) {
            case 'document':
                $extensions = $this->getExtensions(
                    'format.documents.extensions',
                    Extensions::DOCUMENTS
                );
                break;
            case 'image':
                $extensions = $this->getExtensions(
                    'format.images.extensions',
                    Extensions::IMAGES
                );
                break;
            case 'video':
                $extensions = $this->getExtensions(
                    'format.video.extensions',
                    Extensions::VIDEOS
                );
                break;
            case 'audio':
                $extensions = $this->getExtensions(
                    'format.audio.extensions',
                    Extensions::AUDIO
                );
                break;
            default:
                $extensions = [];
        }

        return [
            'mimetypes' => $this->getMimes($extensions, $missing) ?? [],
            'extensions' => $extensions,
        ];
    }

    /**
     * @param mixed $values
     * @param array $missing
     *
     * @return array
     */
    private function getMimes($values, &$missing = [])
    {
        $extensions = array_column(MimesExtensions::VALUES, 'extension');
        $mimes = array_column(MimesExtensions::VALUES, 'mime');
        $values = array_map(
            static function ($extenstion) {
                return '.' === substr($extenstion, 0, \strlen('.')) ?
                    strtolower($extenstion) :
                    strtolower(".$extenstion");
            },
            $values
        );
        $result = [];
        foreach ($values as $key => $value) {
            if ($key = array_search($value, $extensions, true)) {
                $result[] = $mimes[$key];
                continue;
            }
            $missing[] = $value;
        }

        return $result;
    }

    private function getExtensions(string $key, array $default = [])
    {
        return null !== $this->extensionsBag ?
            $this->extensionsBag->get($key, $default) : $default;
    }
}
