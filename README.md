# BEAUBUS PHP Favicon package

Choose your favicon from 110+ free favicons. Each favicon is available in 12 sizes.

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

## Options
You can override default colors when generating tags
```php
$favicon->tags([
    'mask-icon' => '#5bbad5',
    'msapplication-TileColor' => '#2d89ef',
    'theme-color' => '#ffffff',
]);
```