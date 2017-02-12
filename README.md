# Laravel DatabaseLogger

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)

Laravel package to log messages into the database instead of, or in addition to, a file.

## Install

Via Composer

``` bash
$ composer require visualappeal/databaselogger
```

## Usage

Add the following lines just before the `return $app` statement in `bootstrap/app.php`:

```
$app->configureMonologUsing(function ($monolog) {
    $monolog->pushHandler(new VisualAppeal\DatabaseLogger\DatabaseHandler);
    
    // If you want to log to files too, e.g. the application has no database connections
    // or the database is down.
    $levels = [
        'debug'     => Monolog\Logger::DEBUG,
        'info'      => Monolog\Logger::INFO,
        'notice'    => Monolog\Logger::NOTICE,
        'warning'   => Monolog\Logger::WARNING,
        'error'     => Monolog\Logger::ERROR,
        'critical'  => Monolog\Logger::CRITICAL,
        'alert'     => Monolog\Logger::ALERT,
        'emergency' => Monolog\Logger::EMERGENCY,
    ];

    $monolog->pushHandler(new Monolog\Handler\RotatingFileHandler(
        storage_path('/logs/laravel.log'),
        7,
        $levels[env('APP_LOG_LEVEL')]
    ));
});

return $app;
```

## Change log

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
