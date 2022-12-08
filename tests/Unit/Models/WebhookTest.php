<?php

use Weblab\WebhookCall\Models\Webhook;

test('test a webhook model has multiple webhook events', function () {
    // create a webhook that has 2 webhook events
    $webhook = Webhook::factory()->hasWebhookEvents(2)->create();

    // assert that the webhook has 2 webhook events
    expect($webhook->webhookEvents)->toHaveCount(2);
});

test('test a webhook model has multiple webhook logs', function () {
    // create a webhook that has 2 webhook logs
    $webhook = Webhook::factory()->hasWebhookLogs(2)->create();

    // assert that the webhook has 2 webhook logs
    expect($webhook->webhookLogs)->toHaveCount(2);
});
