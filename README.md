# Laravel GMO payment package

## Installation

1. You can install the package via composer:

```bash
composer require deha-soft/laravel-gmo-payment
```

2. Optional: The service provider will automatically get registered. Or you may manually add the service provider in your config/app.php file:

```php
'providers' => [
    // ...
    DehaSoft\LaravelGmoPayment\GMOPaymentServiceProvider::class,
];
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.