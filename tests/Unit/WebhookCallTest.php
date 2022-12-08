<?php

use Illuminate\Support\Facades\Queue;
use Spatie\WebhookServer\CallWebhookJob;
use Spatie\WebhookServer\Exceptions\CouldNotCallWebhook;
use Weblab\WebhookCall\Models\Webhook;
use Weblab\WebhookCall\WebhookCall;

test('when the webhook is set for a WebhookCall, the webhook url and secret are set', function () {
    // fake the Bus
    Queue::fake();

    // create a webhook model
    $webhook = Webhook::factory()->create();

    // create a webhook call and set the webhook
    WebhookCall::create()
        ->webhook($webhook)
        ->dispatch();

    // assert that the webhook url and secret are set
    Queue::assertPushed(CallWebhookJob::class, function (CallWebhookJob $job) use ($webhook) {
        expect($job->webhookUrl)->toBe($webhook->url);

        return true;
    });
});

test('when the webhook is not set for a webhook call, an exception is thrown', function () {
    // fake the Bus
    Queue::fake();

    // create a webhook call
    $webhookCall = WebhookCall::create();

    // assert that an exception is thrown
    expect(fn () => $webhookCall->dispatch())
        ->toThrow(CouldNotCallWebhook::class);
});
