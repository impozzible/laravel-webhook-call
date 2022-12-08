# Laravel Webhook Call

A webhook is a way for an app to provide other applications with real-time information. When an event occurs in the app,
a notification is sent in the form of an HTTP request to registered webhooks.

This package allows you to easily store webhook endpoints and events in a database, while the results of the webhook
calls are logged in the database. It is built on top of the excellent [spatie/laravel-webhook-server](https://github.com/spatie/laravel-webhook-server) package, that provides among things
functionality to sign calls and to retry failed calls.
This package makes it easier and adds functionality for managing and tracking webhooks and their associated data.

With this package, you can easily manage and track your webhooks, making it possible to build interfaces for managing
webhooks on top of this.

## Installation

You can install the package via composer:

```bash
composer require weblabnl/laravel-webhook-call
```

After installing the package, you can run the migrations with:

```bash
php artisan migrate
```

## Usage

Calling a webhook is as simple as:

```php
// fetch a webhook from the database
$webhook = Webhook::find(1);

// call the webhook
WebhookCall::create()
    ->wehbook($webhook)
    ->dispatch(); 
```

## Webhook logging

In addition to storing webhook endpoints and events in the database, this package also provides detailed logs of
webhook call results. Both successful and failed results are stored in the database and include information such as
the endpoint response code, response, and the original payload. This makes it easy to track and troubleshoot any issues
with your webhooks.

## Providing the webhook event for the log

When you call a webhook, you can provide an event that will be stored in the log.

```php
// fetch a webhook from the database
$webhook = Webhook::find(1);

$webhookEvent = $webhook->webhookEvents()
    ->where('name', 'order.created')
    ->first();

// call the webhook
WebhookCall::create()
    ->wehbook($webhook)
    ->webhookEvent($webhookEvent)
    ->dispatch(); 
```

After this, the webhook event is available in any log entries related to this webhook call as well

## Entities related to the webhook data

When you call a webhook, you can provide an entity that will be stored in the log.

```php
// fetch a webhook from the database
$webhook = Webhook::find(1);

// fetch an entity from the database
$entity = Order::find(1);

// call the webhook
WebhookCall::create()
    ->wehbook($webhook)
    ->entity($entity)
    ->dispatch(); 
```

After this, the entity is available in any log entries related to this webhook call as well

## More options

More available options for testing and the WebhookCall class can be found on the
[spatie/laravel-webhook-server](https://github.com/spatie/laravel-webhook-server) github page

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

### Security

If you discover any security-related issues, please email development@weblab.nl instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
