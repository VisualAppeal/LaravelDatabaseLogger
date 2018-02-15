# Laravel DatabaseLogger

Laravel package to log messages into a database.

## Install

Via Composer

``` bash
$ composer require visualappeal/databaselogger
```

## Usage

Add the following lines in your `config/logging.php`:

```
'db' => [
    'driver' => 'custom',
    'via' => VisualAppeal\DatabaseLogger\DatabaseLogger::class,
    'level' => env('LOG_LEVEL', 'debug'),
],
```

## Change log

### 1.2.0

* New logging class compatible to Laravel 5.6

### 1.0.0

* First release

## Security

If you discover any security related issues, please email tim@visualappeal.de instead of using the issue tracker.

## Credits

- [VisualAppeal][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/VisualAppeal/DatabaseLogger.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/VisualAppeal/DatabaseLogger
[link-author]: https://github.com/visualappeal
[link-contributors]: ../../contributors
