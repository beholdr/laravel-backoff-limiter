# Desc

[![Latest Version on Packagist](https://img.shields.io/packagist/v/beholdr/laravel-backoff-limiter.svg?style=flat-square)](https://packagist.org/packages/beholdr/laravel-backoff-limiter)

Rate limiter with exponential backoff for Laravel.

## Support us

Do you like **Backoff Limiter**? Please support me via [Boosty](https://boosty.to/beholdr).

## Installation

You can install the package via composer:

```bash
composer require beholdr/laravel-backoff-limiter
```

## Usage

```php
$laravelBackoffLimiter = new Beholdr\LaravelBackoffLimiter();
echo $laravelBackoffLimiter->echoPhrase('Hello, Beholdr!');
```

## Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
