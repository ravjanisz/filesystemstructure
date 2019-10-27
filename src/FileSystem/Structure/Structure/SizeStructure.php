<?php

namespace Rav\FileSystem\Structure\Structure;

use Rav\FileSystem\Structure\FsObject;
use Rav\FileSystem\Structure\Structure as RootStructure;

class SizeStructure extends BaseStructure implements Structure {

    public function get(string $path) {
        $this->init($path);

        $root = $this->getElement($this->basePath);
        $root->setType(FsObject::TYPE_ROOT);
        $this->objectStructure[] = $root;

        $this->scanDir($this->basePath, 0);
        usort($this->objectStructure, [SortHelper::class, $this->orderValue . 'SizeComparator']);

        return $this->objectStructure;
    }

    protected function scanDir(string $directory, int $level) {
        $handle = opendir($directory);
        if ($handle === false) {
            return;
        }

        foreach ($this->readDir($handle, $directory) as $element) {
            $filePath = substr($element, 3);
            if (in_array($filePath, $this->hidden)) {
                continue;
            }

            $element = $this->getElement($filePath);
            switch (true) {
                case is_dir($filePath):
                    $element->setType(FSObject::TYPE_DIRECTORY);

                    $this->scanDir($filePath, $level + 1);
                    break;
                case is_file($filePath):
                    $element->setType(FSObject::TYPE_FILE);
                    break;
            }

            switch ($this->filter) {
                case RootStructure::FILTER_ALL:
                    $this->objectStructure[] = $element;
                    break;
                case RootStructure::FILTER_DIR:
                    if (is_dir($filePath)) {
                        $this->objectStructure[] = $element;
                    }
                    break;
                case RootStructure::FILTER_FILE:
                    if (is_file($filePath)) {
                        $this->objectStructure[] = $element;
                    }
                    break;
            }
        }
    }
}