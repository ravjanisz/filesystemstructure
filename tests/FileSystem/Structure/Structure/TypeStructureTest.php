<?php

use PHPUnit\Framework\TestCase;
use Rav\FileSystem\Structure\Structure\TypeStructure;
use Rav\FileSystem\Structure\FsObject;
use Rav\FileSystem\Structure\Structure as RootStructure;

class TypeStructureTest extends TestCase {

    /** @var $obj TypeStructure */
    private $obj;

    protected function setUp():void {
        $structure = new TypeStructure();
        $structure->setLeadingName(RootStructure::LEADING_NAME_YES);
        $structure->setHidden([]);
        $structure->setFilter(RootStructure::FILTER_ALL);
        $structure->setOrder(RootStructure::ORDER_TYPE);
        $structure->setOrderValue(RootStructure::ORDER_VALUE_ASC);

        $this->obj = $structure;
    }

    public function testStructure() {
        $path = realpath(__DIR__ . '/../assets');

        $response = $this->obj->get($path);

        $this->checkHasNotChildes($response);

        $this->assertEquals(5, count($response));
    }

    public function testNames() {
        $path = realpath(__DIR__ . '/../assets');

        $this->obj->setLeadingName(RootStructure::LEADING_NAME_YES);
        $response = $this->obj->get($path);

        $this->assertEquals(5, count($response));
        $this->assertEquals('assets', $response[0]->getName());
        $this->assertEquals('assets/dir', $response[1]->getName());
        $this->assertEquals('assets/dir/test.txt', $response[2]->getName());
        $this->assertEquals('assets/dir/test2.txt', $response[3]->getName());
        $this->assertEquals('assets/test3.txt', $response[4]->getName());

        $this->obj->setLeadingName(RootStructure::LEADING_NAME_NO);
        $response = $this->obj->get($path);

        $this->assertEquals('', $response[0]->getName());
        $this->assertEquals('dir', $response[1]->getName());
        $this->assertEquals('test3.txt', $response[2]->getName());
        $this->assertEquals('dir/test.txt', $response[3]->getName());
        $this->assertEquals('dir/test2.txt', $response[4]->getName());
    }

    public function testHidden() {
        $path = realpath(__DIR__ . '/../assets');
        $hidden = realpath(__DIR__ . '/../assets/dir');

        $this->obj->setHidden([$hidden]);
        $response = $this->obj->get($path);

        $this->checkHasNotChildes($response);

        $this->assertEquals(2, count($response));
    }

    public function testFilter() {
        $path = realpath(__DIR__ . '/../assets');

        $this->obj->setFilter(RootStructure::FILTER_ALL);
        $response = $this->obj->get($path);

        $this->checkHasNotChildes($response);
        $this->assertEquals(5, count($response));

        $this->obj->setFilter(RootStructure::FILTER_DIR);
        $response = $this->obj->get($path);

        $this->checkHasNotChildes($response);
        $this->assertEquals(2, count($response));

        $this->obj->setFilter(RootStructure::FILTER_FILE);
        $response = $this->obj->get($path);

        $this->checkHasNotChildes($response);
        $this->assertEquals(4, count($response));
    }

    public function testOrderValue() {
        $path = realpath(__DIR__ . '/../assets');

        $this->obj->setOrderValue(RootStructure::ORDER_VALUE_ASC);
        $response = $this->obj->get($path);

        $this->checkHasNotChildes($response);
        $this->assertEquals(5, count($response));
        $this->assertEquals('assets', $response[0]->getName());
        $this->assertEquals('assets/dir', $response[1]->getName());
        $this->assertEquals('assets/dir/test.txt', $response[2]->getName());
        $this->assertEquals('assets/dir/test2.txt', $response[3]->getName());
        $this->assertEquals('assets/test3.txt', $response[4]->getName());

        $this->obj->setOrderValue(RootStructure::ORDER_VALUE_DESC);
        $response = $this->obj->get($path);

        $this->checkHasNotChildes($response);
        $this->assertEquals(5, count($response));
        $this->assertEquals('assets/dir/test2.txt', $response[0]->getName());
        $this->assertEquals('assets/test3.txt', $response[1]->getName());
        $this->assertEquals('assets/dir/test.txt', $response[2]->getName());
        $this->assertEquals('assets/dir', $response[3]->getName());
        $this->assertEquals('assets', $response[4]->getName());
    }

    public function testTypeStructureAsc() {
        $structure = new TypeStructure();
        $structure->setLeadingName(RootStructure::LEADING_NAME_YES);
        $structure->setHidden([]);
        $structure->setFilter(RootStructure::FILTER_ALL);
        $structure->setOrder(RootStructure::ORDER_TYPE);
        $structure->setOrderValue(RootStructure::ORDER_VALUE_ASC);

        $response = $structure->get(__DIR__ . '/../assets3');
        $this->assertEquals(true, is_array($response));
    }

    public function testTypeStructureDesc() {
        $structure = new TypeStructure();
        $structure->setLeadingName(RootStructure::LEADING_NAME_YES);
        $structure->setHidden([]);
        $structure->setFilter(RootStructure::FILTER_ALL);
        $structure->setOrder(RootStructure::ORDER_TYPE);
        $structure->setOrderValue(RootStructure::ORDER_VALUE_DESC);

        $response = $structure->get(__DIR__ . '/../assets3');
        $this->assertEquals(true, is_array($response));
    }

    private function checkHasNotChildes($response) {
        $this->assertEquals(true, is_array($response));
        foreach ($response as $object) {
            $this->assertInstanceOf(FsObject::class, $object);

            $childes = $object->getChildes();
            $this->assertEquals(false, $object->hasChildes());
            $this->assertEquals(0, count($childes));
        }
    }
}