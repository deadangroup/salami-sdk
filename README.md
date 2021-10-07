# Salami API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/deadangroup/salami-sdk.svg?style=flat-square)](https://packagist.org/packages/deadangroup/salami-sdk)

[![StyleCI](https://styleci.io/repos/88621289/shield?branch=master)](https://styleci.io/repos/88621289)

[![Total Downloads](https://img.shields.io/packagist/dt/deadangroup/salami-sdk.svg?style=flat-square)](https://packagist.org/packages/deadangroup/salami-sdk)

This is a minimal PHP implementation of the [Salami API](https://salami.co.ke). 

## Installation

You can install the package via composer:

``` bash
composer require deadangroup/salami-sdk
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Deadan\Salami\Providers\ModuleServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
    'pay_api_token'          => env('SALAMI_PAY_API_TOKEN'),
    'sms_api_token'          => env('SALAMI_SMS_API_TOKEN'),
    'signature_verification' => env('SALAMI_VERIFY_SIGNATURES', true),
    'sms_app_id'             => env('SALAMI_SMS_APP'),
    'pay_app_id'             => env('SALAMI_PAY_APP'),
];
```

## Usage

The first thing you need to do is get an api token at Salami. 

Look in [the source code of `Deadan\Salami\Sdk`](https://github.com/deadangroup/salami-sdk/blob/master/src/Plugins/BaseSdk.php) to discover the methods you can use.

Here's an example:
Here are a few examples on how you can use the package:

```php
use Deadan\Salami\Facades\SalamiPay;
use Deadan\Salami\Facades\SalamiSms;
//
SalamiPay::fetchTransactions();

//send an sms via a specific app
SalamiSms::sendRaw("+254728270795", "Hi");

```

This package exposes an api IPN endpoint for Salami at ``'/api/salami/callback'``.

When a Salami IPN is received, the package emmits the following event:``Deadan\Salami\Events\SalamiTransactionProcessed`.
You should implement a listener for this event to save the transaction. An example is shown below:

```php
<?php

namespace App\Listeners;

use Deadan\Salami\Events\SalamiTransactionProcessed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveSalamiTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \Deadan\Salami\Events\SalamiTransactionProcessed
     */
    protected $event;

    /**
     * ProcessSalamiTransaction constructor.
     *
     * @param  \Deadan\Salami\Events\SalamiTransactionProcessed  $event
     */
    public function __construct(SalamiTransactionProcessed $event)
    {
        $this->event = $event;
    }

    /**
     *
     */
    public function handle()
    {
        $salamiTransaction = $this->event->transaction;

        if ($salamiTransaction->isCompleted()) {

            $reference = $salamiTransaction->getAttribute('reference');

            //do something.
        }
    }
}

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
