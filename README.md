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