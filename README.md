# php-string-tags

[![Total Downloads](https://img.shields.io/packagist/dt/rafaeldsb/php-string-tags.svg)](https://packagist.org/packages/rafaeldsb/php-string-tags)
[![Latest Stable Version](https://img.shields.io/packagist/v/rafaeldsb/php-string-tags.svg)](https://packagist.org/packages/rafaeldsb/php-string-tags)
![Codacy grade](https://img.shields.io/codacy/grade/00857d9397734c85a190e20e9f756469)
![Codacy coverage](https://img.shields.io/codacy/coverage/00857d9397734c85a190e20e9f756469)
![CircleCI](https://img.shields.io/circleci/build/github/Rafaeldsb/php-string-tags)

This package is a helper for tags in strings 

## Installation

```bash
composer require rafaeldsb/php-string-tags
```

## Basic Usage

```php
<?php

use RafaelDsb\Helpers\Tag;

$string = 'A string with a {{key}} and a {{tag}}';

$keys = Tag::getTags($string); // It returns ['key', 'tag']

$newString = Tag::replaceTags($string, ['key' => 'little key', 'tag' => 'door']);
echo $newString; // A string with a little key and a door

```

## Advanced Usage

You can use it with other characters to process the tags

```php
<?php

use RafaelDsb\Helpers\Tag;

$string = 'A string with a <key> and a <tag>';

$keys = Tag::getTags($string, '<', '>'); // It returns ['key', 'tag']

$newString = Tag::replaceTags($string, ['key' => 'little key', 'tag' => 'door'], '<', '>');
echo $newString; // A string with a little key and a door

```