<?php

namespace Drewlabs\Storage;

use Drewlabs\DataURI\Contracts\DataURI;
use Drewlabs\DataURI\Parser;
use Drewlabs\Psr7Stream\StreamFactory;
use Drewlabs\Storage\Contracts\MimeTypeGuesser as MimeTypeGuesserInterface;
use Drewlabs\Storage\Contracts\PathResource;
use Drewlabs\Storage\Contracts\UploadedFile as ContractsUploadedFile;
use Drewlabs\Storage\Exceptions\FileException;
use InvalidArgumentException;
use JsonSerializable;
use LogicException;
use Psr\Http\Message\{StreamInterface, UploadedFileInterface};
use RuntimeException;
use SplFileInfo;

/** @package Drewlabs\Storage */
class UploadedFile implements ContractsUploadedFile, JsonSerializable
{

    /**
     *
     * @var resource|string
     */
    private $content;

    /**
     *
     * @var int
     */
    private $size;

    /**
     *
     * @var string
     */
    private $extension;

    /**
     *
     * @var string
     */
    private $mimeType;

    /**
     *
     * @var MimeTypeGuesserInterface
     */
    private $mimeTypeGuesser;

    /**
     *
     * @param string|UploadedFileInterface|\SplFileInfo|DataURI $resource
     * @return self
     * @throws InvalidArgumentException
     * @throws FileException
     * @throws LogicException
     * @throws RuntimeException
     */
    public function __construct($resource)
    {
        // We set the default mime type guesser
        $this->useDefaultMimeTypeGuesser();
        if (is_string($resource)) {
            $this->createFromString($resource);
        } else if ($resource instanceof DataURI) {
            $this->createFromDataURI($resource);
        } else if (($resource instanceof \SplFileInfo) && $resource->isReadable()) {
            $this->createFromSplFileInfo($resource);
        } else if ($resource instanceof UploadedFileInterface) {
            $this->createFromPsrUploadedFileInterface($resource);
        } else {
            throw new InvalidArgumentException('Content entry is not a valid file object');
        }
    }

    /**
     * Creates an instance of the class from an parameter bag instance
     *
     * @param \Drewlabs\Contracts\Validator\ViewModel|mixed $viewModel
     * @return self
     */
    public static function createFromViewModel($viewModel)
    {
        /**
         * @var \SplFileInfo|UploadedFileInterface $content
         */
        if (null === $content = $viewModel->file('content')) {
            $content = $viewModel->get('content');
            if (!is_string($content)) {
                throw new InvalidArgumentException('Expected view model to contains a string of file ressource ' . (is_object($content) && !(null === $content) ? get_class($content) : gettype($content)) . ' given');
            }
        }
        return new static($content);
    }

    /**
     * 
     * @param MimeTypeGuesserInterface $guesser 
     * @return self 
     */
    public function setMimeTypeGuesser(MimeTypeGuesserInterface $guesser)
    {
        $this->mimeTypeGuesser = $guesser;
        return $this;
    }

    /**
     * 
     * @return PathResource|string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * 
     * @return int 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * 
     * @return string 
     */
    public function getExtension()
    {
        return $this->extension ?: $this->mimeTypeGuesser->gessExtension($this->mimeType);
    }

    /**
     * 
     * @return string 
     */
    public function getMimeType()
    {
        return $this->mimeType ?: $this->mimeTypeGuesser->gessMimeType($this->extension);
    }

    /**
     * 
     * @return (int|string)[] 
     */
    public function toArray()
    {
        return [
            'size' => $this->getSize(),
            'extension' => $this->getExtension(),
            'mime_type' => $this->getMimeType() ?: 'application/octet-stream'
        ];
    }

    /**
     * 
     * @param DataURI $resource 
     * @return void 
     * @throws InvalidArgumentException 
     */
    private function createFromDataURI(DataURI $resource)
    {
        $this->content = $resource->getContent();
        $this->extension = $resource->getExtension();
        $this->size = create_psr_stream($this->content)->getSize();
    }

    /**
     * 
     * @param SplFileInfo $resource 
     * @return void 
     * @throws FileException 
     */
    private function createFromSplFileInfo(\SplFileInfo $resource)
    {
        $this->content = $this->getSplFileContent($resource);
        $this->size = $resource->getSize() ?: 0;
        try {
            $this->mimeType = MimeTypeGuesser::gessMimeTypeFromPath($resource->getPathname());
            $this->extension = $this->mimeTypeGuesser->gessExtension($this->mimeType);
        } catch (\LogicException $e) {
            $this->extension = !empty($extension = $resource->getExtension()) ?
                $extension : (method_exists($resource, 'getClientOriginalExtension') ? $resource->getClientOriginalExtension() : "");
        }
    }

    /**
     * 
     * @param UploadedFileInterface $resource 
     * @return void 
     * @throws RuntimeException 
     */
    private function createFromPsrUploadedFileInterface(UploadedFileInterface $resource)
    {
        $stream = $resource->getStream();
        $this->createFromPsrStream($stream);
    }

    /**
     * 
     * @param string $resource 
     * @return void 
     * @throws InvalidArgumentException 
     */
    private function createFromString(string $resource)
    {
        try {
            $this->createFromDataURI(Parser::parse($resource));
        } catch (\Throwable $e) {
            try {
                $stream = StreamFactory::createStreamFrom($resource);
                $this->createFromPsrStream($stream);
            } catch (\Throwable $e) {
                throw new InvalidArgumentException('Expect string resource to base a valid data uri string or a stream resource');
            }
        }
    }

    /**
     * 
     * @param StreamInterface $stream 
     * @return void 
     * @throws RuntimeException 
     */
    private function createFromPsrStream(StreamInterface $stream)
    {
        if (!$stream->isReadable()) {
            throw new RuntimeException('Resource is not a readable stream.');
        }
        // Move the pointer to the begin of the stream to make sure
        // the entire content is read
        $stream->rewind();
        $this->content = $stream->getContents();
        $uri = $stream->getMetadata('uri');
        $contentType = mime_content_type($uri);
        $this->mimeType = $contentType;
        $this->size = $stream->getSize() ?: 0;
    }

    private function useDefaultMimeTypeGuesser()
    {
        $this->mimeTypeGuesser = new MimeTypeGuesser;
    }

    /**
     * 
     * @param SplFileInfo $content 
     * @return string 
     * @throws FileException 
     */
    private function getSplFileContent(\SplFileInfo $content): string
    {
        $path = $content->getPathname();
        $content = file_get_contents($path);
        if (false === $content) {
            throw new FileException(sprintf('Could not get the content of the file "%s".', $path));
        }
        return $content;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->getContent();
    }

    public function __toString()
    {
        return $this->getContent();
    }
}
