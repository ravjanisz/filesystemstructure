<?php

use PHPUnit\Framework\TestCase;
use Rav\FileSystem\Structure\Structure\NameStructure;
use Rav\FileSystem\Structure\FsObject;
use Rav\FileSystem\Structure\Structure as RootStructure;

class NameStructureTest extends TestCase {

    /** @var $obj NameStructure */
    private $obj;

    protected function setUp():void {
        $structure = new NameStructure();
        $structure->setLeadingName(RootStructure::LEADING_NAME_YES);
        $structure->setHidden([]);
        $structure->setFilter(RootStructure::FILTER_ALL);
        $structure->setOrder(RootStructure::ORDER_NAME);
        $structure->setOrderValue(RootStructure::ORDER_VALUE_ASC);

        $this->obj = $structure;
    }

    public function testStructure() {
        $path = realpath(__DIR__ . '/../assets');

        $response = $this->obj->get($path);

        $this->assertInstanceOf(FsObject::class, $response);

        $childes = $response->getChildes();
        $this->assertEquals(true, $response->hasChildes());
        $this->assertEquals(2, count($childes));

        $child = $childes[0];
        $childes = $child->getChildes();
        $this->assertEquals(true, $child->hasChildes());
        $this->assertEquals(2, count($childes));

        $child11 = $childes[0];
        $childes11 = $child11->getChildes();
        $this->assertEquals(false, $child11->hasChildes());
        $this->assertEquals(0, count($childes11));

        $child12 = $childes[1];
        $childes12 = $child12->getChildes();
        $this->assertEquals(false, $child12->hasChildes());
        $this->assertEquals(0, count($childes12));
    }

    public function testNames() {
        $path = realpath(__DIR__ . '/../assets');

        $this->obj->setLeadingName(RootStructure::LEADING_NAME_YES);
        $response = $this->obj->get($path);
        $this->assertEquals('assets', $response->getName());

        $this->obj->setLeadingName(RootStructure::LEADING_NAME_NO);
        $response = $this->obj->get($path);
        $this->assertEquals('', $response->getName());
    }

    public function testHidden() {
        $path = realpath(__DIR__ . '/../assets');
        $hidden = realpath(__DIR__ . '/../assets/dir');

        $this->obj->setHidden([$hidden]);
        $response = $this->obj->get($path);
        $this->assertEquals(true, $response->hasChildes());
        $this->assertEquals(1, count($response->getChildes()));
    }

    public function testFilter() {
        $path = realpath(__DIR__ . '/../assets');

        $this->obj->setFilter(RootStructure::FILTER_ALL);
        $response = $this->obj->get($path);
        $this->assertEquals(2, count($response->getChildes()));

        $path = realpath(__DIR__ . '/../assets/dir');
        $this->obj->setFilter(RootStructure::FILTER_DIR);
        $response = $this->obj->get($path);
        $this->assertEquals(0, count($response->getChildes()));

        $this->obj->setFilter(RootStructure::FILTER_FILE);
        $response = $this->obj->get($path);
        $this->assertEquals(2, count($response->getChildes()));
    }

    public function testOrderValue() {
        $path = realpath(__DIR__ . '/../assets');

        $this->obj->setOrderValue(RootStructure::ORDER_VALUE_ASC);
        $response = $this->obj->get($path);
        $childes = $response->getChildes();
        $child1 = $childes[0];
        $child2 = $childes[1];
        $this->assertEquals(2, count($childes));
        $this->assertEquals('assets/dir', $child1->getName());
        $this->assertEquals('assets/test3.txt', $child2->getName());

        $this->obj->setOrderValue(RootStructure::ORDER_VALUE_DESC);
        $response = $this->obj->get($path);
        $childes = $response->getChildes();
        $child1 = $childes[0];
        $child2 = $childes[1];
        $this->assertEquals(2, count($childes));
        $this->assertEquals('assets/test3.txt', $child1->getName());
        $this->assertEquals('assets/dir', $child2->getName());
    }

    public function testSetGet() {
        $this->obj->setLeadingName(RootStructure::LEADING_NAME_YES);
        $this->assertEquals(RootStructure::LEADING_NAME_YES, $this->obj->getLeadingName());

        $this->obj->setFilter(RootStructure::FILTER_DIR);
        $this->assertEquals(RootStructure::FILTER_DIR, $this->obj->getFilter());

        $this->obj->setHidden(['zonk']);
        $this->assertEquals(['zonk'], $this->obj->getHidden());

        $this->obj->setOrder(RootStructure::ORDER_NAME);
        $this->assertEquals(RootStructure::ORDER_NAME, $this->obj->getOrder());

        $this->obj->setOrderValue(RootStructure::ORDER_VALUE_ASC);
        $this->assertEquals(RootStructure::ORDER_VALUE_ASC, $this->obj->getOrderValue());
    }
}