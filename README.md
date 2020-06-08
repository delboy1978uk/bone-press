# press
Press package for Bone Mvc Framework
## installation
Use Composer
```
composer require delboy1978uk/bone-press
```
## usage
Simply add to the `config/packages.php`
```php
<?php

// use statements here
use Bone\Press\PressPackage;

return [
    'packages' => [
        // packages here...,
        PressPackage::class,
    ],
    // ...
];
```