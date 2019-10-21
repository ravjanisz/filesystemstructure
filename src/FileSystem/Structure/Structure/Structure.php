<?php

namespace Rav\FileSystem\Structure\Structure;

interface Structure {

    public function setHidden(array $hidden);
    public function setFilter(int $filter);
    public function get(string $path);
}