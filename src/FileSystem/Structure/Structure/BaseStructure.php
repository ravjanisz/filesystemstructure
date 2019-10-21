<?php

namespace Rav\FileSystem\Structure\Structure;

use Rav\FileSystem\Structure\FileSystemStructureException;
use Rav\Size\SizeSettings;
use Rav\ObjectSize\ObjectSize;
use Rav\FileSystem\Structure\Structure as RootStructure;
use Rav\FileSystem\Structure\FsObject;

abstract class BaseStructure implements Structure {

    protected $objectSize;

    protected $leadingName;
    protected $hidden;
    protected $filter;
    protected $order;
    protected $orderValue;

    protected $objectStructure;
    protected $listStructure;
    protected $basePath;
    protected $basePathLength;
    protected $basePosition;

    public function __construct() {
        $settings = new SizeSettings();
        $settings->setPrecision(2);

        $this->objectSize = new ObjectSize($settings);
    }

    public function setLeadingName(string $leadingName) {
        $this->leadingName = $leadingName;
    }

    public function setHidden(array $hidden) {
        $this->hidden = $hidden;
    }

    public function setFilter(int $filter) {
        $this->filter = $filter;
    }

    public function setOrder(int $order) {
        $this->order = $order;
    }

    public function setOrderValue(string $orderValue) {
        $this->orderValue = $orderValue;
    }

    abstract function get(string $path);

    protected function readDir($handle, string $directory) {
        $elements = [];
        while (($entry = readdir($handle)) !== false) {
            if ($entry == '.' or $entry == '..') {
                continue;
            }

            $elementEntry = $directory . DIRECTORY_SEPARATOR . $entry;
            switch (true) {
                case is_dir($elementEntry): $elements[] = 'D: ' . $elementEntry; break;
                case is_file($elementEntry): $elements[] = 'F: ' . $elementEntry; break;
                default: throw new FileSystemStructureException('Invalid file system object type.');
            }
        }
        closedir($handle);
        natcasesort($elements);

        if ($this->orderValue == RootStructure::ORDER_VALUE_DESC) {
            $elements = array_reverse($elements);
        }

        return $elements;
    }

    public function init(string $path) {
        $this->basePath = realpath($path);
        $this->basePathLength = strlen($this->basePath);

        $this->basePosition = strlen($this->basePath) + 1;
        if ($this->leadingName == RootStructure::LEADING_NAME_YES) {
            $this->basePosition = strrpos($this->basePath, '/') + 1;
        }
    }

    public function getElement($name, $path) {
        $element = new FsObject();
        $element->setName($name);
        $element->setPath($path);
        $element->setTime(filectime($path));
        $this->objectSize->setPath($path);
        $element->setSize($this->objectSize->inBytes());

        return $element;
    }
}