<?php

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Spatie\WebhookServer\Events\FinalWebhookCallFailedEvent;
use Spatie\WebhookServer\Events\WebhookCallFailedEvent;
use Spatie\WebhookServer\Events\WebhookCallSucceededEvent;
use Weblab\WebhookCall\Exceptions\WebhookCallListenerException;
use Weblab\WebhookCall\Listeners\WebhookCallListener;
use Weblab\WebhookCall\Models\Webhook;
use Weblab\WebhookCall\Models\WebhookEvent;
use Weblab\WebhookCall\Models\WebhookLog;
use Weblab\WebhookCall\Tests\Model\Order;

test('the WebhookCallListener is called when the FinalWebhookCallFailedEvent, WebhookCallFailedEvent or WebhookCallSucceededEvent event is dispatched', function () {
    // fake the event bus
    Event::fake();

    // assert that the listener listens to the event
    Event::assertListening(FinalWebhookCallFailedEvent::class, WebhookCallListener::class);
    Event::assertListening(WebhookCallFailedEvent::class, WebhookCallListener::class);
    Event::assertListening(WebhookCallSucceededEvent::class, WebhookCallListener::class);
});

test('whenever the WebhookCallListener is called, a new webhook_logs record is created', function () {
    // create a webhook entity
    $webhook = Webhook::factory()->create();

    // create a webhook event
    $webhookEvent = WebhookEvent::factory()->create();

    // dispatch the event
    createAndDispatchEvent($webhook, $webhookEvent);

    // assert that the webhook_logs table has 1 record
    $this->assertEquals(1, WebhookLog::count());
});

test('if a webhook is missing and the event triggers the listener, an exception is thrown', function () {
    // create a webhook entity
    $webhook = Webhook::factory()->create();

    // create a webhook event and set the webhook_id to null and check if an exception was thrown
    expect(fn () => event(new FinalWebhookCallFailedEvent(
        'POST',
        'http://127.0.0.1',
        [],
        [],
        [],
        [],
        1,
        null,
        null,
        null,
        Str::uuid(),
        null
    )))->toThrow(WebhookCallListenerException::class);
});

test('if a non existing webhook is addedto the event the event triggers the listener, an exception is thrown', function () {
    // create a webhook entity
    $webhook = Webhook::factory()->create();

    expect(fn () => event(new FinalWebhookCallFailedEvent(
        'POST',
        $webhook->url,
        [],
        [],
        ['webhook_id' => 999],
        [],
        1,
        null,
        null,
        null,
        Str::uuid(),
        null
    )))->toThrow(WebhookCallListenerException::class);
});

test('whenever a the event contains a webhook_event_id, the event is added to the webhook log', function () {
    // create a webhook entity
    $webhook = Webhook::factory()->create();

    // create a webhook event
    $webhookEvent = WebhookEvent::factory()->create();

    // dispatch the event
    createAndDispatchEvent($webhook, $webhookEvent);

    // assert that the weblog_event_id is the same as the webhook event id
    $this->assertEquals($webhookEvent->id, WebhookLog::first()->webhook_event_id);
});

test('whenever a the event contains no webhook_event_id, the event is not added to the webhook log', function () {
    // create a webhook entity
    $webhook = Webhook::factory()->create();

    // dispatch the event
    createAndDispatchEvent($webhook);

    // assert that the weblog_event_id is null
    expect(WebhookLog::first()->webhook_event_id)
        ->toBeNull();
});

test('whenever a the event contains a entity_id and entity_type, the entity is added to the webhook log', function () {
    // create a webhook entity
    $webhook = Webhook::factory()->create();

    // create a webhook event
    $order = Order::create(['name' => 'John Doe', 'email' => 'john.doe@example.com', 'product' => 'Test product']);

    // dispatch the event
    event(new FinalWebhookCallFailedEvent(
        'POST',
        $webhook->url,
        [],
        [],
        ['webhook_id' => $webhook->id, 'entity_id' => $order->id, 'entity_type' => Order::class],
        [],
        1,
        null,
        null,
        null,
        Str::uuid(),
        null
    ));

    // get the webhook log
    $webhookLog = WebhookLog::first();

    // assert that the weblog_event_id is the same as the webhook event id
    expect($webhookLog->entity)->toBeInstanceOf(Order::class)
        ->and($webhookLog->entity->id)->toBe($order->id);
});

test('whenever a the event contains no entity_id and entity_type, the entity is not dded to the webhook log', function () {
    // create a webhook entity
    $webhook = Webhook::factory()->create();

    // create a webhook event
    $order = Order::create(['name' => 'John Doe', 'email' => 'john.doe@example.com', 'product' => 'Test product']);

    // dispatch the event
    event(new FinalWebhookCallFailedEvent(
        'POST',
        $webhook->url,
        [],
        [],
        ['webhook_id' => $webhook->id],
        [],
        1,
        null,
        null,
        null,
        Str::uuid(),
        null
    ));

    // assert that there is no entity
    expect(WebhookLog::first()->entity)->toBeNull();
});

test('the attempt number a webhook has been tried is added to the webhook log', function () {
    // create a webhook entity
    $webhook = Webhook::factory()->create();

    // dispatch the event
    createAndDispatchEvent($webhook, null, 5);

    // assert that the weblog_event_id is the same as the webhook event id
    expect(5)->toBe(WebhookLog::first()->attempt);
});

test('the name of the triggered event is added to the webhook log', function () {
    // create a webhook entity
    $webhook = Webhook::factory()->create();

    // dispatch the event
    createAndDispatchEvent($webhook, null, 5);

    // assert that the weblog_event_id is the same as the webhook event id
    expect(FinalWebhookCallFailedEvent::class)->toBe(WebhookLog::first()->event_name);
});

/**
 * Create and dispatch an event.
 *
 * @param   Webhook                     $webhook The webhook entity
 * @param   WebhookEvent|null           $webhookEvent The webhook event entity
 * @param   int|null                    $attempt The attempt number
 * @return void
 */
function createAndDispatchEvent(Webhook $webhook, ?WebhookEvent $webhookEvent = null, ?int $attempt = 1): void {
    // dispatch the event
    event(new FinalWebhookCallFailedEvent(
        'POST',
        $webhook->url,
        [],
        [],
        ['webhook_id' => $webhook->id, 'webhook_event_id' => $webhookEvent?->id],
        [],
        $attempt,
        null,
        null,
        null,
        Str::uuid(),
        null
    ));
}
