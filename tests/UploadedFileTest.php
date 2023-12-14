<?php

use Drewlabs\Storage\UploadedFile;
use PHPUnit\Framework\TestCase;

use function Drewlabs\Filesystem\Proxy\Path;

class UploadedFileTest extends TestCase
{

    private function getDataString()
    {
        return require __DIR__ . '/Resources/msword.php';
    }

    public function test_constructor_with_string()
    {
        $content = $this->getDataString();
        $resource = new UploadedFile($content);
        $this->assertSame('application/vnd.openxmlformats-officedocument.wordprocessingml.document', $resource->getMimeType());
        $this->assertEquals('docx', $resource->getExtension());
    }

    public function test_contructor_with_spl_file_info()
    {
        $resource = new UploadedFile(new SplFileInfo(__DIR__ . '/Resources/photo.png'));
        $this->assertSame('image/png', $resource->getMimeType());
        $this->assertEquals('png', $resource->getExtension());
    }

    public function test_contructor_with_psr_stream()
    {
        $resource = new UploadedFile((string)Path(__DIR__ . '/Resources/photo.png')->canonicalize());
        $this->assertSame('image/jpeg', $resource->getMimeType());
        $this->assertEquals('jpeg', $resource->getExtension());
    }

    public function test_constructor_with_view_model()
    {
        $resource = UploadedFile::createFromViewModel(new class($this->getDataString())
        {
            public function __construct(string $raw)
            {
                $this->files = [
                    'content' => new SplFileInfo(__DIR__ . '/Resources/photo.png')
                ];
    
                $this->inputs = [
                    'content' => $raw
                ];
            }

            public function file(string $key)
            {
                return $this->files[$key] ?? null;
            }

            public function get(string $key)
            {
                return $this->inputs[$key] ?? null;
            }
        });

        $this->assertInstanceOf(UploadedFile::class, $resource);
        $this->assertSame('image/png', $resource->getMimeType());
        $this->assertEquals('png', $resource->getExtension());
    }

    public function test_create_from_view_model_throws_invalid_argument_execption()
    {
        $this->expectException(InvalidArgumentException::class);
        $resource = UploadedFile::createFromViewModel(new class()
        {
            public function file(string $key)
            {
                return null;
            }
            public function get(string $key)
            {
                return null;
            }
        });
        $this->assertInstanceOf(UploadedFile::class, $resource);
    }
}
