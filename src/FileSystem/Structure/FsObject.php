<?php

namespace Rav\FileSystem\Structure;

use Rav\Size\SizeSettings;
use Rav\ObjectSize\ObjectSize;

class FsObject {

    const TYPE_ROOT = 1;
    const TYPE_DIRECTORY = 2;
    const TYPE_FILE = 3;

    private static $timeFormat = 'Y-m-d H:i:d';

    private $type;
    private $path;
    private $name;
    private $size;
    private $time;

    private $objectSize;

    private $hasChildes;
    private $childes;

    public function __construct() {
        $settings = new SizeSettings();
        $settings->setPrecision(2);

        $this->objectSize = new ObjectSize($settings);

        $this->childes = [];
        $this->hasChildes = false;
    }

    public function setType($type) {
        if (!in_array($type, [FsObject::TYPE_DIRECTORY, FsObject::TYPE_FILE, FsObject::TYPE_ROOT])) {
            throw new FileSystemStructureException('Invalid file system object type.');
        }

        $this->type = $type;
    }

    public function setPath($path) {
        $this->path = $path;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setSize($size) {
        $this->size = $size;
    }

    public function setTime($time) {
        $this->time = $time;
    }

    public function addChild($child) {
        $this->childes[] = $child;
        $this->hasChildes = true;
    }

    public function getChildes() {
        return $this->childes;
    }

    public function hasChildes() {
        return $this->hasChildes;
    }

    public function getType() {
        return $this->type;
    }

    public function getPath() {
        return $this->path;
    }

    public function getName() {
        return $this->name;
    }

    public function getSize() {
        return $this->size;
    }

    public function getTime() {
        return $this->time;
    }

    public function humanSize() {
        $this->objectSize->setPath($this->path);

        return $this->objectSize->human();
    }

    public function humanTime() {
        return date(self::$timeFormat, $this->time);
    }
}