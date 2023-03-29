# Calculate with Public Holidays in PHP
[![Latest Version on Packagist](https://img.shields.io/packagist/v/portavice/public-holidays-calculator.svg?style=flat-square)](https://packagist.org/packages/portavice/public-holidays-calculator)
<a href="https://packagist.org/packages/portavice/public-holidays-calculator"><img src="https://img.shields.io/packagist/php-v/portavice/public-holidays-calculator.svg?style=flat-square" alt="PHP from Packagist"></a>
[![Total Downloads](https://img.shields.io/packagist/dt/portavice/public-holidays-calculator.svg?style=flat-square)](https://packagist.org/packages/portavice/public-holidays-calculator)

This package allows you to calculate with public holidays and working days in PHP
based on an extension of the [Carbon](https://github.com/briannesbitt/Carbon) library.

## Usage

### Installation
To install this package with [Composer](https://getcomposer.org/):

```bash
composer require portavice/public-holidays-calculator
```

### Use the `Carbon` extension

```php
<?php

use Carbon\Carbon;
use Portavice\PublicHolidays\Carbon\Calculator;

Calculator::register(); // Register Carbon macros
Carbon::setPublicHolidays([
    new FixedHoliday(1, 1), // New Year
    FlexibleHoliday::EasterMonday,
]);

$jan01 = Carbon::create(2022, 1, 1);
$jan01->isWorkingDay(); // false

$dec27 = Carbon::create(2022, 12, 27);
$dec->isWorkingDay(); // true

$dec27->subWorkingDays(2); // 2022-12-22
$dec27->subWorkingDay(); // 2022-12-23

$dec27->addWorkingDay(); // 2022-12-28
$dec27->addWorkingDays(10); // 2023-01-10
```

## Development

### How to develop
- Run `composer install` to install the dependencies for PHP.
- Run `composer test` to run all PHPUnit tests.
- Run `composer cs` to check compliance with the code style and `composer csfix` to fix code style violations before every commit.

### Code Style
PHP code MUST follow [PSR-12 specification](https://www.php-fig.org/psr/psr-12/).

We use [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) for the PHP code style check.
