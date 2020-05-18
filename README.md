# A minimal implementation of Salami API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/deadan/salami-sdk.svg?style=flat-square)](https://packagist.org/packages/deadan/salami-sdk)

[![StyleCI](https://styleci.io/repos/88621289/shield?branch=master)](https://styleci.io/repos/88621289)

[![Total Downloads](https://img.shields.io/packagist/dt/deadan/salami-sdk.svg?style=flat-square)](https://packagist.org/packages/deadan/salami-sdk)

This is a minimal PHP implementation of the [Salami API](https://salami.co.ke). 

## Installation

You can install the package via composer:

``` bash
composer require deadan/salami-sdk
```

## Usage

The first thing you need to do is get an authorization token at Salami. 

Look in [the source code of `Deadan\Salami\Sdk`](https://github.com/deadan/salami-sdk/blob/master/src/Sdk.php) to discover the methods you can use.

Here's an example:
Here are a few examples on how you can use the package:

```php
$client = new Deadan\Salami\Sdk($apiToken);
$sms=$client->sms();

//send an sms via a specific app
$sms->sendRaw($to, $message, $appId)

//get a specific sms app
$sms->getSmsApp($appId);

```

If you need to change the subdomain of the endpoint URL used in the API request, you can prefix the endpoint path with `subdomain::`.

Here's an example:

```php
$client->rpcEndpointRequest('content::files/get_thumbnail_batch', $parameters);
```


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information about recent changes.

## Upgrading

Please see [UPGRADING](UPGRADING.md) for details.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email james@deadangroup.com instead of using the issue tracker.

## Credits

- [James Ngugi](https://github.com/ngugijames)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
