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

## Available favicon names
Light bulb, Calendar, Folder, Flash drive, Printer, Scissors, Laptop, Ruler, Ring binders, Push Pin, Clip, Briefcase, Speech bubble, Pencil, Crayons, Notepad, Palette, Notepad closed, Roadworks sign, Envelope, Avatar glasses, Stop sign, Avatar tooth, Stethoscope, Target, Bearing, Warning sign, Saturn, Neptune, Mercury, Earth dark, Earth, Uranus, Mars, Jupiter, Volleyball, Tennis, Pool, Soccer, Basketball, Rhombus, Calculator, Cell phone, Quadcopter, Amanita mushroom, Russula mushroom, Desk fan, Sewing machine, Triangle, Trapezoid, Toaster, Blender, Hand saw, Tulip, Chainsaw, Juicer, Pocket watch, Old bicycle, TV, Smart watch, Bowling, Pluto, Square, Parallelogram, Octagon, Avatar smiling, Avatar star, Avatar mustache, Avatar hat, Circle, Saw disk, Red face, Spiral, Fidget spinner, Handheld console, Tablet, Beech mushroom, Button mushroom, Chanterelle mushroom, Porcini mushroom, Hair dryer, Washing machine, Clothes iron, Electric kettle, Mixer, Fridge, Circular saw, French keys, Screwdriver, Sunflower, Pot, Teapot, Magnifying glass, Mirror, Cuckoo clock, Round clock, Hammer, Wild rose, Sakura, Dandelion, Electric scooter, Cartoon car, Van, Old wheel, Frying pan, Coffee mug, White dish, Microscope, Timer, Telescope, Binocular, Chamomile, Kaleidoscope, Vaze, Train, Square clock