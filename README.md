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
    'level' => env('LOG_LEVEL', 'debug'), // Optional
    'connection' => env('LOG_DATABASE', 'mysql'), // Optional
    'table' => env('LOG_TABLE', 'logs'), // Optional
    
    // Encryption requires sodium: https://secure.php.net/manual/en/book.sodium.php
    'encrypt' => env('LOG_ENCRYPT', false), // Optional, encrypt the context part of the log message before inserting it into the database
    'encrypt_key' => env('LOG_ENCRYPT_KEY', env('APP_KEY', '')), // Optional, only used if encrypt is true
],
```

Database migrations are automatically registered, you only have to call `php artisan migrate` after installing the package.

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
