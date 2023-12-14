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

class Extensions
{
    /**
     * List of video files possible web extensions.
     */
    public const VIDEOS = [
        'webm', 'mkv', 'flv', 'ogg', 'gif', 'avi', 'wmv', 'mp4', 'm4v', 'mpeg', '3gp',
    ];

    /**
     * List of images files possible web extensions.
     */
    public const IMAGES = [
        'jpg', 'jpeg', 'bmp', 'png', 'pdf', 'gif', 'webp', 'tiff', 'psd', 'raw', 'heif',
    ];

    /**
     * List of documents files possible web extensions.
     */
    public const DOCUMENTS = [
        'docx', 'doc', 'pdf', 'xlxs', 'odt', 'doc', 'docx', 'xls', 'xlsx', 'docx', 'rtf', 'ppt', 'pptx', 'txt', 'csv',
    ];

    /**
     * List of audio files possible web extensions.
     */
    public const AUDIO = [
        'mp3', 'm4a', 'aac', 'ogg', 'oga', 'flac', 'pcm', 'wav', 'aiff',
    ];
}
