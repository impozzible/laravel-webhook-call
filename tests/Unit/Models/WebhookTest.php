<?php

use Weblab\WebhookCall\Models\Webhook;

test('a webhook model has multiple webhook events', function () {
    // create a webhook that has 2 webhook events
    $webhook = Webhook::factory()->hasWebhookEvents(2)->create();

    // assert that the webhook has 2 webhook events
    expect($webhook->webhookEvents)->toHaveCount(2);
});

test('whenever a webhook event is linked to a webhook, the timestamps are set', function () {
    // create a webhook that has 2 webhook events
    $webhook = Webhook::factory()->hasWebhookEvents(2)->create();

    // assert that the webhook events have timestamps
    expect($webhook->webhookEvents->first()->pivot->created_at)->toBeInstanceOf(Carbon\Carbon::class);
    expect($webhook->webhookEvents->first()->pivot->updated_at)->toBeInstanceOf(Carbon\Carbon::class);
});

test('a custom webhook event model can be used', function () {
    // create a webhook that has 1 webhook event
    $webhook = Webhook::factory()->hasWebhookEvents(1)
        ->create();

    // set a custom webhook event model
    config()->set('webhook-call.models.webhook_event', \Weblab\WebhookCall\Tests\Model\CustomWebhookEvent::class);

    // assert that the custom webhook event model is being used
    expect($webhook->webhookEvents->first())->toBeInstanceOf(\Weblab\WebhookCall\Tests\Model\CustomWebhookEvent::class);
});

test('a webhook model has multiple webhook logs', function () {
    // create a webhook that has 2 webhook logs
    $webhook = Webhook::factory()->hasWebhookLogs(2)->create();

    // assert that the webhook has 2 webhook logs
    expect($webhook->webhookLogs)->toHaveCount(2);
});

test('a custom webhook log model can be used', function () {
    // create a webhook that has 1 webhook log
    $webhook = Webhook::factory()->hasWebhookLogs(1)
        ->create();

    // set a custom webhook log model
    config()->set('webhook-call.models.webhook_log', \Weblab\WebhookCall\Tests\Model\CustomWebhookLog::class);

    // assert that the custom webhook log model is being used
    expect($webhook->webhookLogs->first())->toBeInstanceOf(\Weblab\WebhookCall\Tests\Model\CustomWebhookLog::class);
});
