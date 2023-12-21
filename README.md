# Backoff Limiter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/beholdr/laravel-backoff-limiter.svg?style=flat-square)](https://packagist.org/packages/beholdr/laravel-backoff-limiter)

Rate limiter with exponential backoff for Laravel.

Imagine that you want to verify your customer's phone number by sending an SMS code. But sending SMS is expensive and you don't want to allow too many requests. Laravel has [RateLimiter](https://laravel.com/docs/rate-limiting) class, but it is very simple. Let's say you accept 1 attempt per minute, but this allows some unfriendly person to send 1 SMS every minute without any penalties.

Using `BackoffLimiter` class you can increase backoff exponentially with every attempt. For example, first retry will be available in 1 minute, second in 4 minutes, third in 9 minutes etc. Backoff time is determined by the formula:

```
backoff_time = decay_time * attempts ^ exponent
```

## Support

Do you like **Backoff Limiter**? Please support me via [Boosty](https://boosty.to/beholdr).

## Installation

You can install the package via composer:

```bash
composer require beholdr/laravel-backoff-limiter
```

## Usage

You can use this package as default `RateLimiter` class:

```php
use Beholdr\BackoffLimiter\BackoffLimiter;

$executed = app(BackoffLimiter::class)->attempt(
    'send-sms-'.request()->ip(),
    maxAttempts: 1,
    function () {
        // Send SMS
    }
)

if (! $executed) {
    throw new Exception('Too many requests!');
}
```

Or you can manually control attempts:

```php
use Beholdr\BackoffLimiter\BackoffLimiter;

$limiter = app(BackoffLimiter::class);
$key = 'send-sms-'.request()->ip();

if ($limiter->tooManyAttempts($key, 1)) {
    throw new Exception('Too many requests!');
}

$limiter->hit($key)

// Send SMS
```

You can set up:

- **Backoff window**: the time interval during which attempts are counted. Default is `1 hour`
- **Exponent**: determine backoff time duration. Default is `2`

To set custom values pass your values at class creation:

```php
$limiter = app(BackoffLimiter::class, ['backoff' => 3*60*60, 'exponent' => 3]);
$limiter->hit(...);
```

## Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
