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

use Drewlabs\Filesystem\Contracts\Filesystem as ContractsFilesystem;
use Drewlabs\Filesystem\Helpers\FilesystemManager;
use function Drewlabs\Filesystem\Proxy\FilesystemManager;

use Drewlabs\Storage\Contracts\FileSystem as FilesystemInterface;
use Drewlabs\Storage\Contracts\UploadedFile;
use Drewlabs\Storage\UploadedFile as CoreUploadedFile;

class Filesystem implements FilesystemInterface
{
    /**
     * @var string
     */
    private $disk;

    /**
     * 
     * @param string $disk 
     * @return self 
     */
    public function __construct(string $disk = 'local')
    {
        $this->disk = $disk ?? 'local';
    }

    public function disk(string $disk)
    {
        $this->disk = $disk;

        return $this;
    }

    public function put(string $path, UploadedFile $contents)
    {
        return $this->getDisk()
            ->write(
                $path,
                $contents->getContent(),
                ['visibility' => 'public']
            );
    }

    public function get(string $path)
    {
        return new CoreUploadedFile($this->getDisk()
            ->read($path));
    }

    public function url(string $path)
    {
        if ($this->pathExists($path)) {
            return 'local' === FilesystemManager::getDefaultDriver() ?
                $this->getDisk()->url(ltrim($path, \DIRECTORY_SEPARATOR)) :
                $this->getDisk()->url($path);
        }
        return null;
    }

    public function path(string $path)
    {
        return $this->url($path);
    }

    public function isFile(string $path)
    {
        return $this->getDisk()
            ->fileExists($path);
    }

    public function isDirectory($dir)
    {
        return $this->getDisk()
            ->directoryExists($dir);
    }

    public function pathExists(string $path)
    {
        return $this->isFile($path) || $this->isDirectory($path);
    }

    public function copy(string $src, string $dst)
    {
        return $this->getDisk()
            ->copy($src, $dst);
    }

    public function move(string $src, string $dst)
    {
        return $this->getDisk()
            ->move($src, $dst);
    }

    public function delete(string $path)
    {
        if ($this->isDirectory($path)) {
            return $this->getDisk()->deleteDirectory($path);
        }

        return $this->getDisk()->delete($path);
    }

    #region Miscellanous

    /**
     * Miscellanous function getting the disk object internally.
     *
     * @throws \InvalidArgumentException
     *
     * @return ContractsFilesystem
     */
    private function getDisk()
    {
        return FilesystemManager()->disk($this->disk);
    }
    #endregion Miscellanous
}
