<?php

namespace Rav\FileSystem\Structure;

use Rav\FileSystem\Structure\Structure\NameStructure;
use Rav\FileSystem\Structure\Structure\TypeStructure;
use Rav\FileSystem\Structure\Structure\SizeStructure;
use Rav\FileSystem\Structure\Structure\TimeStructure;

class Structure {

    const LEADING_NAME_YES = 1;
    const LEADING_NAME_NO = 2;

    const FILTER_ALL = 1;
    const FILTER_DIR = 2;
    const FILTER_FILE = 3;

    const ORDER_NAME = 1;
    const ORDER_TYPE = 2;
    const ORDER_SIZE = 3;
    const ORDER_TIME = 4;

    const ORDER_VALUE_ASC = 'asc';
    const ORDER_VALUE_DESC = 'desc';

    const RESULT_OBJECT = 1;
    const RESULT_ARRAY = 2;

    private $leadingName;
    private $hidden;
    private $filter;
    private $order;
    private $orderValue;

    public function __construct($leadingName = Structure::LEADING_NAME_NO) {
        if (!in_array($leadingName, [Structure::LEADING_NAME_YES, Structure::LEADING_NAME_NO])) {
            throw new FileSystemStructureException('Invalid structure option - leading name.');
        }
        $this->leadingName = $leadingName;
        $this->hidden = [];
        $this->filter = Structure::FILTER_ALL;
        $this->order = Structure::ORDER_NAME;
        $this->orderValue = Structure::ORDER_VALUE_ASC;
    }

    public function hide($value) {
        if (!is_array($value)) {
            $this->hidden[] = $value;

            return $this;
        }

        foreach ($value as $v) {
            $this->hidden[] = $v;
        }

        return $this;
    }

    public function filter($filter) {
        if (!in_array($filter, [Structure::FILTER_ALL, Structure::FILTER_DIR, Structure::FILTER_FILE])) {
            throw new FileSystemStructureException('Invalid structure filter.');
        }

        $this->filter = $filter;

        return $this;
    }

    public function order(int $order, string $value) {
        if (!in_array($order, [Structure::ORDER_NAME, Structure::ORDER_TYPE, Structure::ORDER_SIZE, Structure::ORDER_TIME])) {
            throw new FileSystemStructureException('Invalid structure order.');
        }

        $this->order = $order;

        if (!in_array($value, [Structure::ORDER_VALUE_ASC, Structure::ORDER_VALUE_DESC])) {
            throw new FileSystemStructureException('Invalid structure order value.');
        }

        $this->orderValue = $value;

        return $this;
    }

    public function get(string $path) {
        if (!file_exists($path)) {
            throw new FileSystemStructureException("'$path' it's not exists.");
        }

        switch ($this->order) {
            case Structure::ORDER_NAME: $structure = new NameStructure(); break;
            case Structure::ORDER_TYPE: $structure = new TypeStructure(); break;
            case Structure::ORDER_SIZE: $structure = new SizeStructure(); break;
            case Structure::ORDER_TIME: $structure = new TimeStructure(); break;
            default: throw new FileSystemStructureException('Invalid structure order.');
        }

        $structure->setLeadingName($this->leadingName);
        $structure->setHidden($this->hidden);
        $structure->setFilter($this->filter);
        $structure->setOrder($this->order);
        $structure->setOrderValue($this->orderValue);

        return $structure->get($path);
    }
}