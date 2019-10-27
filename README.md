# filesystemstructure

[![Build Status](https://travis-ci.org/ravjanisz/filesystemstructure.svg?branch=master)](https://travis-ci.org/ravjanisz/filesystemstructure)
[![codecov](https://codecov.io/gh/ravjanisz/filesystemstructure/branch/master/graph/badge.svg)](https://codecov.io/gh/ravjanisz/filesystemstructure)

List you directory structure as a objects tree. Exclude directories from list. Filter by directory or file. Order by name (default - structure), type, time and size.

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

//create new structure
$structure = new Structure();

//exclude object from structure
$structure
    ->hide('full_path_file_or_directory');
    
//exclude objects from structure
$structure   
    ->hide(['full_path_file_or_directory1', 'full_path_file_or_directory2']);
        
//list only directories or files, or both
$structure 
    ->filter(Structure::FILTER_DIR);
$structure
    ->filter(Structure::FILTER_FILE);
$structure 
    ->filter(Structure::FILTER_ALL);
    
//order by size - get folders and files order by their size
//return array of object - Rav\FileSystem\Structure\FsObject -flat
//can by ordered ascending and descending
$structure
    ->order(Structure::ORDER_SIZE, Structure::ORDER_VALUE_DESC);
$structure
    ->order(Structure::ORDER_SIZE, Structure::ORDER_VALUE_ASC);
  
//order by time - get folders and files order by their modified time
//return array of object - Rav\FileSystem\Structure\FsObject -flat
//can by ordered ascending and descending
$structure
    ->order(Structure::ORDER_TIME, Structure::ORDER_VALUE_DESC);
$structure
    ->order(Structure::ORDER_TIME, Structure::ORDER_VALUE_ASC);
   
//order by type - get folders and files order by their filetype
//return array of object - Rav\FileSystem\Structure\FsObject -flat
//can by ordered ascending and descending
$structure
    ->order(Structure::ORDER_TYPE, Structure::ORDER_VALUE_DESC);
$structure
    ->order(Structure::ORDER_TYPE, Structure::ORDER_VALUE_ASC);
    
//order by name - get whole directory structure
//return object - Rav\FileSystem\Structure\FsObject - tree
//can by ordered ascending and descending
$structure
    ->order(Structure::ORDER_NAME, Structure::ORDER_VALUE_DESC);
$structure
    ->order(Structure::ORDER_NAME, Structure::ORDER_VALUE_ASC);
    
$path = __DIR__ . '/files';    
$outputStructure = $structure->get($path);

//get first element for order by: time, type and size or object tree for order by name

//get object type
echo $outputStructure->getType();
//get object full path
echo $outputStructure->getPath();
//get file/directory name
echo $outputStructure->getName();
//get size in bytes
echo $outputStructure->getSize();
//get timestamp
echo $outputStructure->getTime();
//get human readable size
echo $outputStructure->humanSize();
//get human readable time
echo $outputStructure->humanTime();
//check if object has childes
echo $outputStructure->hasChildes();
//get objects array - Rav\FileSystem\Structure\FsObject - tree
//only for order by name
echo $outputStructure->getChildes();
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
 