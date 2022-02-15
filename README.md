# Salami API SDK

[![StyleCI](https://styleci.io/repos/88621289/shield?branch=master)](https://styleci.io/repos/88621289)

This is a minimal PHP implementation of the [Salami API](https://salami.co.ke).

## Installation

You can install the package via composer:

``` bash
composer require deadangroup/salami-sdk
```

## Usage: Payments

The first thing you need to do is get an api token at Salami.

Look
in [the source code of `Deadan\Salami\Plugins\SalamiPay`](https://github.com/deadangroup/salami-sdk/blob/master/src/Plugins/SalamiPay.php)
to discover the methods you can use.

```php
use Deadan\Salami\Plugins\SalamiPay;

//First create an instance
$apiToken = 'api_token';  //gotten from salami.co.ke
$webhookSecret = 'webhook_secret';  //gotten from salami.co.ke
$verify = true;  
$paymentAppId = 1;  //gotten from salami.co.ke
  
$salamiPay = (new SalamiPay($apiToken, $webhookSecret))
->setSignatureVerification($verify)
->setAppId($paymentAppId); 

//Init a transaction
//Note: The fields passed depend on the payment app driver
$result = $salamiPay->requestPayment([  
  'Amount' => 10,  
  'PhoneNumber' => '+254711800780',  
  'AccountReference' => 'INV110',  
  'TransactionDesc' => 'Invoice payment',  
]);

//fetch transactions
$transactions= $salamiPay->fetchTransactions();

//process webhooks
return $salamiPay->processWebhook($request);

```

When a Salami Payment IPN is received, the package emmits the following event:
``Deadan\Salami\Events\SalamiTransactionProcessed``. 

You should implement a listener for this event to save the transaction. 
An example is shown below:

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
        //the sdk will automatically detect whether multitenancy is enabled and a tenant is available.
        //if none, the context will be `salami_no_tenant` else it will be `salami_tenant_{TENANT_ID}`
        // e.g. salami_tenant_10
        if ($this->event->context == 'salami_no_tenant') {
            $salamiTransaction = $this->event->transaction;

            if ($salamiTransaction->isCompleted()) {
                //do something.
            }
        }
    }
}
```

## Usage: SMS

The first thing you need to do is get an api token at Salami.

Look
in [the source code of `Deadan\Salami\Plugins\SalamiSms`](https://github.com/deadangroup/salami-sdk/blob/master/src/Plugins/SalamiSms.php)
to discover the methods you can use.

```php
use Deadan\Salami\Plugins\SalamiSms;
//First create an instance
$apiToken = 'api_token';  //gotten from salami.co.ke
$webhookSecret = 'webhook_secret';  //gotten from salami.co.ke
$verify = true;  
$smsAppId = 1;  //gotten from salami.co.ke
  
$salamiSms = (new SalamiSms($apiToken, $webhookSecret))
->setSignatureVerification($verify)
->setAppId($smsAppId); 

//send an sms via the specific app
$salamiSms->sendRaw("+254728270795", "Hi");

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