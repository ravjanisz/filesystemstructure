<?php

use PHPUnit\Framework\TestCase;
use Rav\FileSystem\Structure\Structure;
use Rav\FileSystem\Structure\FileSystemStructureException;
use Rav\FileSystem\Structure\FsObject;

class StructureTest extends TestCase {

    /** @var $obj Structure */
    private $obj;

    protected function setUp():void {
        $this->obj = new Structure();
    }

    public function testInvalidConstruct() {
        $this->expectException(FileSystemStructureException::class);
        $structure = new Structure('asd');
    }

    public function testIsConstructValid() {
        $this->assertInstanceOf(Structure::class, $this->obj);
    }

    public function testHide() {
        $this->assertEquals(0, count($this->obj->getHidden()));
        $this->obj->hide(__DIR__ . '/assets/dir/test.txt');
        
        $hidden = $this->obj->getHidden();
        $this->assertEquals(1, count($hidden));
        $this->assertEquals(__DIR__ . '/assets/dir/test.txt', $hidden[0]);

        $this->obj->hide([__DIR__ . '/assets/dir/test.txt', __DIR__ . '/assets/dir/test2.txt']);

        $hidden = $this->obj->getHidden();
        $this->assertEquals(3, count($hidden));
        $this->assertEquals(__DIR__ . '/assets/dir/test.txt', $hidden[1]);
        $this->assertEquals(__DIR__ . '/assets/dir/test2.txt', $hidden[2]);
    }

    public function testFilterFails() {
        $this->expectException(FileSystemStructureException::class);
        $this->obj->filter('zonk');
    }

    public function testFilter() {
        $this->obj->filter(Structure::FILTER_ALL);
        $this->assertEquals(Structure::FILTER_ALL, $this->obj->getFilter());
    }

    public function testOrderFails() {
        $this->expectException(FileSystemStructureException::class);
        $this->obj->order(5, Structure::ORDER_VALUE_ASC);
    }

    public function testOrderValueFails() {
        $this->expectException(FileSystemStructureException::class);
        $this->obj->order(Structure::ORDER_NAME, 'asd');
    }

    public function testOrderAndOrderValue() {
        $this->obj->order(Structure::ORDER_NAME, Structure::ORDER_VALUE_ASC);
        $this->assertEquals(Structure::ORDER_NAME, $this->obj->getOrder());
        $this->assertEquals(Structure::ORDER_VALUE_ASC, $this->obj->getOrderValue());
    }

    public function testStrucutreGetFails() {
        $this->obj->order(Structure::ORDER_NAME, Structure::ORDER_VALUE_ASC);
        $this->expectException(FileSystemStructureException::class);
        $this->obj->get('asd');
    }

    public function testStrucutreGetName() {
        $this->obj->order(Structure::ORDER_NAME, Structure::ORDER_VALUE_ASC);
        $response = $this->obj->get(__DIR__ . '/assets');

        $this->assertInstanceOf(FsObject::class, $response);
    }

    public function testStrucutreGetSize() {
        $this->obj->order(Structure::ORDER_SIZE, Structure::ORDER_VALUE_ASC);
        $response = $this->obj->get(__DIR__ . '/assets');

        $this->assertEquals(true, is_array($response));
    }

    public function testStrucutreGetTime() {
        $this->obj->order(Structure::ORDER_TIME, Structure::ORDER_VALUE_ASC);
        $response = $this->obj->get(__DIR__ . '/assets');

        $this->assertEquals(true, is_array($response));
    }

    public function testStrucutreGetType() {
        $this->obj->order(Structure::ORDER_TYPE, Structure::ORDER_VALUE_ASC);
        $response = $this->obj->get(__DIR__ . '/assets');

        $this->assertEquals(true, is_array($response));
    }
}