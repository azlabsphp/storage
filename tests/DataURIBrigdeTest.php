<?php

use Drewlabs\Storage\DataURIBrigde;
use PHPUnit\Framework\TestCase;

class DataURIBrigdeTest extends TestCase
{

    private function getDataString()
    {
        return require __DIR__.'/Resources/msword.php';
    }

    public function test_create_data()
    {
        $content = $this->getDataString();
        $bridge = new DataURIBrigde();
        $resource = $bridge->create($content);
        $this->assertSame('application/vnd.openxmlformats-officedocument.wordprocessingml.document', $resource->getMimeType(), 'Expect created data object mimetype to equals application/vndopenxmlformats-officedocumentwordprocessingmldocument');
        $this->assertTrue($resource->isBinary());
        $this->assertEquals('docx', $resource->getExtension());
    }
}