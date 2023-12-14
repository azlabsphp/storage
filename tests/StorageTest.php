<?php

use Drewlabs\Filesystem\Helpers\ConfigurationManager;
use Drewlabs\Storage\Contracts\UploadedFile;
use Drewlabs\Storage\UploadedFile as CoreUploadedFile;
use PHPUnit\Framework\TestCase;

use function Drewlabs\Filesystem\Proxy\Path;
use function Drewlabs\Storage\Proxy\Storage;
use function Drewlabs\Storage\Proxy\useStorage;

class StorageTest extends TestCase
{

    protected function setUp(): void
    {
        ConfigurationManager::configure([
            'default' => 'local',
            'cloud' => 's3',
            'disks' => [
                'local' => [
                    'driver' => 'local',
                    'root' => (string)Path(__DIR__ . '/Resources'),
                    'url' => null,
                ],
                'public' => [
                    'driver' => 'local',
                    'root' => '',
                    'url' => null,
                    'visibility' => 'public',
                ]

            ]
        ]);
    }

    private function removeTestingObjects(string $path)
    {
        Storage()->disk('local')->delete($path);
    }

    private function createTestFile()
    {
        $path  = 'depth1/depth2/depth3/photo';
        $file = new CoreUploadedFile(new SplFileInfo(__DIR__ . '/Resources/photo.png'));
        Storage()->disk('local')->put($path, $file);
        return $path;
    }

    private function run_test_scenario(\Closure $testFn)
    {
        $path = $this->createTestFile();
        $testFn($path);
        $this->removeTestingObjects($path);
    }

    public function test_storage_get()
    {
        $result = useStorage()->local->get('photo.png');
        $this->assertInstanceOf(UploadedFile::class, $result);
        $this->assertTrue($result->getSize() !== 0);
    }

    public function test_storage_put()
    {
        $this->run_test_scenario(function ($path) {
            $this->assertTrue(useStorage()->local->isFile($path));
        });
    }

    public function test_storage_path_exists()
    {
        $this->run_test_scenario(function ($path) {
            $this->assertTrue(useStorage()->local->pathExists($path));
        });
    }

    public function test_storage_is_directory()
    {
        $this->run_test_scenario(function ($path) {
            $this->assertFalse(useStorage()->local->isDirectory($path));
            $this->assertTrue(useStorage()->local->isDirectory(Path($path)->dirname()));
        });
    }

    public function test_storage_copy()
    {
        $this->run_test_scenario(function ($path) {
            $dest = 'depth3/depth4/depth5/photo';
            useStorage()->local->copy($path, $dest);
            $this->assertTrue(useStorage()->local->isFile($dest));
            $this->removeTestingObjects($dest);
        });
    }

    public function test_use_storage_is_direcory()
    {
        $this->run_test_scenario(function ($path) {
            $this->assertFalse(useStorage()->local->isDirectory($path));
            $this->assertTrue(useStorage()->local->isDirectory(Path($path)->dirname()));
        });
    }
}
