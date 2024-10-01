<?php

namespace Weblab\WebhookCall\Listeners;

use Spatie\WebhookServer\Events\WebhookCallEvent;
use Weblab\WebhookCall\Exceptions\WebhookCallListenerException;

/**
 * Class FinalWebhookCallFailedListener
 */
class WebhookCallListener
{
    /**
     * Handle the event.
     *
     * @param  WebhookCallEvent  $event  The event
     *
     * @throws WebhookCallListenerException
     */
    public function handle(WebhookCallEvent $event)
    {
        // if the webhook id is not set, we can't do anything, throw an exception
        if (! isset($event->meta['webhook_id'])) {
            throw new WebhookCallListenerException('Event could not be linked to a webhook because the webhook has not been set.');
        }

        // find the webhook in the database
        $webhook = config('webhook-call.models.webhook')::find($event->meta['webhook_id']);

        // if the webhook is not found, return
        if (! $webhook) {
            throw new WebhookCallListenerException('Event could not be linked to a webhook because the webhook does not exist.');
        }

        // if an entity_id and entity_type is set, get the entity
        $entity = null;
        if (isset($event->meta['entity_id']) && isset($event->meta['entity_type'])) {
            $entity = $event->meta['entity_type']::find($event->meta['entity_id']);
        }

        $newPayload = is_string($event->payload) ? json_decode($event->payload, true, 512, JSON_THROW_ON_ERROR) : $event->payload;

        $newPayload['headers'] = $event->headers;

        // create a new webhook log
        $webhook->webhookLogs()
            ->create([
                'webhook_event_id' => $event->meta['webhook_event_id'] ?? null,
                'entity_id' => $entity?->id,
                'entity_type' => ! is_null($entity) ? get_class($entity) : null,
                'payload' => $newPayload,
                'attempt' => $event->attempt,
                'event_name' => get_class($event),
                'http_verb' => $event->httpVerb,
                'http_code' => $event->response?->getStatusCode(),
                'response_body' => $event->response?->getBody()->getContents(),
            ]);
    }
}
