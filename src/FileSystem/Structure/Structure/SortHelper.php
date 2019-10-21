<?php

namespace Rav\FileSystem\Structure\Structure;

use Rav\FileSystem\Structure\FsObject;

class SortHelper {

    public static function ascSizeComparator(FsObject $object1, FsObject $object2) {
        return $object1->getSize() > $object2->getSize();
    }

    public static function descSizeComparator(FsObject $object1, FsObject $object2) {
        return $object1->getSize() < $object2->getSize();
    }

    public static function ascTimeComparator(FsObject $object1, FsObject $object2) {
        return $object1->getTime() > $object2->getTime();
    }

    public static function descTimeComparator(FsObject $object1, FsObject $object2) {
        return $object1->getTime() < $object2->getTime();
    }

    public static function ascTypeComparator(FsObject $object1, FsObject $object2) {
        if ($object1->getType() == $object2->getType()) {
            if ($object1->getType() !== FsObject::TYPE_FILE) {
                return false;
            }

            $dot1 = strrpos($object1->getName(), '.');
            $dot2 = strrpos($object2->getName(), '.');

            $dir1 = strrpos($object1->getName(), '/');
            $dir2 = strrpos($object2->getName(), '/');

            switch (true) {
                case $dot1 and $dot2: break;
                case $dot1 and !$dot2: return true;
                case !$dot1 and $dot2: return false;
                case !$dot1 and !$dot2:
                    $name1 = substr($object1->getName(), $dir1 + 1);
                    $name2 = substr($object2->getName(), $dir2 + 1);

                    return $name1 > $name2;
            }

            $ext1 = substr($object1->getName(), $dot1 + 1);
            $ext2 = substr($object2->getName(), $dot2 + 1);

            if ($ext1 === $ext2) {
                $name1 = substr($object1->getName(), $dir1 + 1, -1 * $dot1 + 1);
                $name2 = substr($object2->getName(), $dir2 + 1, -1 * $dot2 + 1);

                return $name1 > $name2;
            }

            return $ext1 > $ext2;
        }

        return $object1->getType() > $object2->getType();
    }

    public static function descTypeComparator(FsObject $object1, FsObject $object2) {
        if ($object1->getType() == $object2->getType()) {
            if ($object1->getType() !== FsObject::TYPE_FILE) {
                return false;
            }

            $dot1 = strrpos($object1->getName(), '.');
            $dot2 = strrpos($object2->getName(), '.');

            $dir1 = strrpos($object1->getName(), '/');
            $dir2 = strrpos($object2->getName(), '/');

            switch (true) {
                case $dot1 and $dot2: break;
                case $dot1 and !$dot2: return false;
                case !$dot1 and $dot2: return true;
                case !$dot1 and !$dot2:
                    $name1 = substr($object1->getName(), $dir1 + 1);
                    $name2 = substr($object2->getName(), $dir2 + 1);

                    return $name1 < $name2;
            }

            $ext1 = substr($object1->getName(), $dot1 + 1);
            $ext2 = substr($object2->getName(), $dot2 + 1);

            if ($ext1 === $ext2) {
                $name1 = substr($object1->getName(), $dir1 + 1, -1 * $dot1 + 1);
                $name2 = substr($object2->getName(), $dir2 + 1, -1 * $dot2 + 1);

                return $name1 < $name2;
            }

            return $ext1 < $ext2;
        }

        return $object1->getType() < $object2->getType();
    }
}