# Laravel DatabaseLogger

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)

Laravel package to log messages into the database instead of, or in addition to, a file.

## Install

Via Composer

``` bash
$ composer require VisualAppeal/DatabaseLogger
```

## Usage

Add the following lines just before the `return $app` statement in `bootstrap/app.php`:

```
$app->configureMonologUsing(function ($monolog) {
    $monolog->pushHandler(new VisualAppeal\DatabaseLogger\DatabaseHandler);
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

[link-packagist]: https://packagist.org/packages/:vendor/:package_name
[link-travis]: https://travis-ci.org/:vendor/:package_name
[link-author]: https://github.com/visualappeal
[link-contributors]: ../../contributors
