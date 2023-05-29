# BEAUBUS PHP Favicon package

Package of [110+ free favicons](https://favicons.beaubus.com) for your vanilla php project (12 sizes for each favicon). 

## Installation
```shell
composer require beaubus/php-favicon
```

## Usage
```php
<?php

require __DIR__ . '/vendor/autoload.php';

$favicon = new \Beaubus\PhpFavicon('/path-to-the/public');
$favicon->init(
    'pocket watch', // Favicon name 
     true           // Check if the favicon has changed. Set it to 'false' once you have chosen and tested your favicon.
 ); 

echo $favicon->tags();
```