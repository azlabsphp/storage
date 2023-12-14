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

namespace Drewlabs\Storage\Contracts;

interface FileSystem
{
    /**
     * Save the file to the storage path.
     *
     * @param mixed|ressource $contents
     *
     * @return bool
     */
    public function put(string $path, UploadedFile $contents);

    /**
     * Get the raw binary content of a file.
     *
     * @return UploadedFile
     */
    public function get(string $path);

    /**
     * Handler for deleting one or more file from the application storage.
     *
     * @param string|array $path
     *
     * @return bool
     */
    public function delete(string $path);

    /**
     * Provide functionnalities for downloading a file at a specific path.
     *
     * @param string $path
     *
     * @return string
     */
    public function url(string $path);

    /**
     * Returns true if the path passed as parameter exists in the file system.
     *
     * @return bool
     */
    public function pathExists(string $path);

    /**
     * Get the path to a given file on the local path.
     *
     * @return string
     */
    public function path(string $path);

    /**
     * Copy a source file to a destination folder.
     *
     * @return bool|void
     */
    public function copy(string $source, string $destination);

    /**
     * Move a source file to a destination folder.
     *
     * @return bool|void
     */
    public function move(string $source, string $destination);

    /**
     * Checks if path is a file.
     *
     * @return bool
     */
    public function isFile(string $path);

    /**
     * Checks if path is a directory.
     *
     * @param string $dir
     *
     * @return bool
     */
    public function isDirectory($dir);
}
