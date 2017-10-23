# Echo.io-php (WIP)

## Installation (laravel 5.3+)
```
$ composer require mediumart/echo.io-php
```
Add the service provider, in `config/app.php`, to the `providers` array (only need for laravel versions prior to 5.5)
```php
Mediumart\Echoio\EchoioServiceProvider::class,
```
Then add a secret key for broadcasting, to `config/services.php` 
```php
'broadcast' => [
    'key' => '<your_secret_key_here>',
],
```
this can be any random string for now, but the exact same secret key should be configured on the [echo.io nodejs server](https://github.com/mediumart/echo.io) side.