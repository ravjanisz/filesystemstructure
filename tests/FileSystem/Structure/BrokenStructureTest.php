<?php

use PHPUnit\Framework\TestCase;
use Rav\FileSystem\Structure\Structure\NameStructure;
use Rav\FileSystem\Structure\Structure\TypeStructure;
use Rav\FileSystem\Structure\Structure as RootStructure;
use Rav\FileSystem\Structure\FileSystemStructureException;

class BrokenStructureTest extends TestCase {

    private $brokenSymlink = __DIR__ . '/assets2/link/brokenSymlink';

    protected function setUp():void {
        $this->removeSymlink($this->brokenSymlink);
        try {
            symlink(__DIR__ . '/assets2/link/test11.txt', $this->brokenSymlink);
        } catch (Exception $e) { }
    }

    public function testInvalidReadDir() {
        $structure = new NameStructure();
        $structure->setLeadingName(RootStructure::LEADING_NAME_YES);
        $structure->setHidden([]);
        $structure->setFilter(RootStructure::FILTER_ALL);
        $structure->setOrder(RootStructure::ORDER_NAME);
        $structure->setOrderValue(RootStructure::ORDER_VALUE_ASC);

        $this->expectException(FileSystemStructureException::class);
        $structure->get(__DIR__ . '/assets2');
    }

    protected function tearDown():void {
        $this->removeSymlink($this->brokenSymlink);
    }

    private function removeSymlink($symlink) {
        if(is_link($symlink) and file_exists($symlink)) {
            unlink($symlink);
        }
    }
}