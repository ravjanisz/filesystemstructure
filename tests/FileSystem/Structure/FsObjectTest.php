<?php

use PHPUnit\Framework\TestCase;
use Rav\FileSystem\Structure\FsObject;
use Rav\FileSystem\Structure\FileSystemStructureException;

class FsObjectTest extends TestCase {

    /** @var $obj FsObject */
    private $obj;

    protected function setUp():void {
        $this->obj = new FsObject();
    }

    public function testInvalidType() {
        $this->expectException(FileSystemStructureException::class);
        $this->obj->setType('asd');
    }

    public function testSetGetType() {
        $this->obj->setType(FsObject::TYPE_DIRECTORY);
        $this->assertEquals(FsObject::TYPE_DIRECTORY, $this->obj->getType());
    }

    public function testSetGetPath() {
        $this->obj->setPath(__DIR__ . '/assets');
        $this->assertEquals(__DIR__ . '/assets', $this->obj->getPath());
    }

    public function testSetGetName() {
        $this->obj->setName('test.txt');
        $this->assertEquals('test.txt', $this->obj->getName());
    }

    public function testSetGetSize() {
        $this->obj->setSize(1024);
        $this->assertEquals(1024, $this->obj->getSize());

        $this->obj->setPath(__DIR__ . '/assets/dir/test.txt');
        $this->assertEquals('9B', $this->obj->humanSize());
    }

    public function testSetGetTime() {
        $this->obj->setTime(1571728917);
        $this->assertEquals(1571728917, $this->obj->getTime());
        $this->assertEquals('2019-10-22 07:21:22', $this->obj->humanTime());
    }

    public function testChildes() {
        $this->assertEquals(false, $this->obj->hasChildes());
        $this->assertEquals(0, count($this->obj->getChildes()));

        $this->obj->addChild($this->obj);
        $this->assertEquals(true, $this->obj->hasChildes());
        $this->assertEquals(1, count($this->obj->getChildes()));
    }
}