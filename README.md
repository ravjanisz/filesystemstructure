# filesystemstructure

[![Build Status](https://travis-ci.org/ravjanisz/filesystemstructure.svg?branch=master)](https://travis-ci.org/ravjanisz/filesystemstructure)
[![codecov](https://codecov.io/gh/ravjanisz/filesystemstructure/branch/master/graph/badge.svg)](https://codecov.io/gh/ravjanisz/filesystemstructure)

Converts file or directory to human readable number by taking the number of that unit that the bytes will go into it.

## Requirements

* PHP >= 7.1
* ravjanisz/objectsize
* (optional) PHPUnit to run tests.

## Install

Via Composer:

```bash
$ composer require ravjanisz/filesystemstructure
```
## Usage

```PHP
use Rav\FileSystem\Structure\Structure;
use Rav\FileSystem\Structure\FsObject;

$path = __DIR__ . '/files';

$structure = new Structure();
$outputStructure = $structure
    ->hide('full_path_file_or_directory')
    ->hide(['full_path_file_or_directory', 'full_path_file_or_directory'])
    ->filter(Structure::FILTER_ALL)
    //->filter(Structure::FILTER_DIR)
    //->filter(Structure::FILTER_FILE)
    //->order(Structure::ORDER_NAME, Structure::ORDER_VALUE_ASC)
    //->order(Structure::ORDER_NAME, Structure::ORDER_VALUE_DESC)
    //->order(Structure::ORDER_SIZE, Structure::ORDER_VALUE_ASC)
    //->order(Structure::ORDER_SIZE, Structure::ORDER_VALUE_DESC)
    //->order(Structure::ORDER_TIME, Structure::ORDER_VALUE_ASC)
    //->order(Structure::ORDER_TIME, Structure::ORDER_VALUE_DESC)
    ->order(Structure::ORDER_TYPE, Structure::ORDER_VALUE_ASC)
    //->order(Structure::ORDER_TYPE, Structure::ORDER_VALUE_DESC)
    ->get($path);
```

## Documentation

None

## Support the development

**Do you like this project? Support it by donating**

<a href="https://www.buymeacoffee.com/ravjanisz">

![alt Buy me a coffee](https://raw.githubusercontent.com/ravjanisz/filesystemstructure/master/docs/assets/bmc.png)

</a>

## License

filesystemstructure is licensed under the MIT License - see the LICENSE file for details 
