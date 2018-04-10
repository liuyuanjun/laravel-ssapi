# laravel-ssapi
A simple laravel server to server api sign and verify class.


## Installation

Pull this package in through Composer.

```js

    {
        "require": {
            "liuyuanjun/ssapi": "1.*"
        }
    }

```

or run in terminal:
`composer require liuyuanjun/ssapi`

## Usage

### Laravel usage

The package provides an easy interface for sending cURL requests from your application. The package provides a fluent
interface similar the Laravel query builder to easily configure the request. There are several utility methods that allow
you to easily add certain options to the request. If no utility method applies, you can also use the general `withOption`
method.

### Sending GET requests

In order to send a `GET` request, you need to use the `get()` method that is provided by the package:

```php

    use Liuyuanjun\SsApi\Facades\SsApi;

    $response = SsApi::server('ServerName')
        ->get($api, $data, $headers);

    /* or
    ->post($api, $data, $headers);
    ->put($api, $data, $headers);
    ->patch($api, $data, $headers);
    ->delete($api, $data, $headers);
    */

```