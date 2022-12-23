<?php

use Weblab\WebhookCall\Models\Webhook;
use Weblab\WebhookCall\Models\WebhookEvent;
use Weblab\WebhookCall\Models\WebhookLog;
use Weblab\WebhookCall\Tests\Model\Order;

test('a webhook belongs to a webhook log', function () {
    // create a webhook log that belongs to a webhook
    $webhookLog = WebhookLog::factory()
        ->for(Webhook::factory())
        ->create();

    // assert that the webhook log belongs to a webhook
    expect($webhookLog->webhook)
        ->toBeInstanceOf(Webhook::class);
});

test('a custom webhook model can be used', function () {
    // create a webhook log that belongs to a webhook
    $webhookLog = WebhookLog::factory()
        ->for(Webhook::factory())
        ->create();

    // set a custom webhook model
    config()->set('webhook-call.models.webhook', \Weblab\WebhookCall\Tests\Model\CustomWebhook::class);

    // assert that the custom webhook model is being used
    expect($webhookLog->webhook)->toBeInstanceOf(\Weblab\WebhookCall\Tests\Model\CustomWebhook::class);
});

test('a webhook belongs to a webhook event', function () {
    // create a webhook log that belongs to a webhook
    $webhookLog = WebhookLog::factory()
        ->for(WebhookEvent::factory())
        ->create();

    // assert that the webhook log belongs to a webhook
    expect($webhookLog->webhookEvent)
        ->toBeInstanceOf(WebhookEvent::class);
});

test('a webhook log payload is an ArrayObject', function () {
    // create a webhook log that belongs to a webhook
    $webhookLog = WebhookLog::factory()
        ->create();

    // assert that the webhook log belongs to a webhook
    expect($webhookLog->payload)
        ->toBeInstanceOf(ArrayObject::class);
});

test('a webhook log response body is an ArrayObject', function () {
    // create a webhook log that belongs to a webhook
    $webhookLog = WebhookLog::factory()
        ->create();

    // assert that the webhook log belongs to a webhook
    expect($webhookLog->response_body)
        ->toBeInstanceOf(ArrayObject::class);
});

test('a webhook log can have webhookable entities', function () {
    // create a new order
    $order = Order::create(['name' => 'John Doe', 'email' => 'john.doe@example.com', 'product' => 'Test product']);

    // create a webhook log that belongs to a webhook
    $webhookLog = WebhookLog::factory()
        ->for($order, 'entity')
        ->create();

    // assert that the webhook log belongs to a webhook
    expect($webhookLog->entity)
        ->toBeInstanceOf(Order::class);
});
