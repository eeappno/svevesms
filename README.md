# Sveve API wrapper

[![Latest Version on Packagist](https://img.shields.io/packagist/v/eeappdev/svevesms.svg?style=flat-square)](https://packagist.org/packages/eeappdev/svevesms)
[![Total Downloads](https://img.shields.io/packagist/dt/eeappdev/svevesms.svg?style=flat-square)](https://packagist.org/packages/eeappdev/svevesms)

Used to send SMS thru Sveve API

```php
// Send an SMS thru the API
use Eeappdev\SveveSms\Sms;
$sms = new Sms();
$sms->to($phonenumber)
    ->message('Content of the message')
    ->send();
```

## Installation

You can install the package via composer:

```bash
composer require eeappdev/svevesms
```

Publish the config if wanted:
```bash
php artisan vendor:publish --provider="Eeappdev\SveveSms\SmsServiceProvider" --tag="config"
```

Add credentials in your `.env` file:

```bash
SVEVE_USER=
SVEVE_PASSWORD=
SVEVE_URL="https://sveve.no/SMS/"
SVEVE_FROM=
```


## Usage

```php
use Eeappdev\SveveSms;

$sms = new Sms();

$sms->to($phonenumber)
    ->from() // set from, if not set, it will come from config
    ->message() // Write your message
    ->test(true) // Will not send the SMS
    ->send(); // Sending the request
```

Send same message to many recipients
```php
$sms = new Sms();
$sms->to([
        '12345678', 
        '23456789'
    ])
    ->message('This message will be sent to both recipients') // Write your message
    ->send(); // Sending the request
```
Send same message to many recipients
```php
$sms = new Sms();
$sms->to(12345678)
    ->to(23456789)
    ->message('This message will be sent to both recipients')
    ->send(); // Sending the request
```

Send different messages, to different recipients
```php
$sms = new Sms();
$sms->to(12345678)
    ->message('This message will be sent to first recipient')
    ->to(23456789)
    ->message('This message will be sent to second recipient')
    ->send(); // Sending the request
```

Check remaining SMS
```php
$sms = new Sms();
$sms->remainingSms(); // Return null or int
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
