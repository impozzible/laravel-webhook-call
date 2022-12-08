<?php

namespace Weblab\WebhookCall;

use Illuminate\Database\Eloquent\Model;
use Spatie\WebhookServer\Exceptions\CouldNotCallWebhook;
use Spatie\WebhookServer\WebhookCall as SpatieWebhookCall;
use Weblab\WebhookCall\Models\Webhook;
use Weblab\WebhookCall\Models\WebhookEvent;

class WebhookCall extends SpatieWebhookCall
{
    /**
     * The webhook model.
     *
     * @var Webhook
     */
    protected Webhook $webhook;

    /**
     * The webhook event model.
     *
     * @var WebhookEvent
     */
    protected WebhookEvent $webhookEvent;

    /**
     * The related entity for the webhook call.
     *
     * @var Model
     */
    protected Model $entity;

    /**
     * Set the URL and secret for the webhook call.
     *
     * @param  Webhook  $webhook The webhook model
     * @return  static            The instance of this class, so we can chain methods
     */
    public function webhook(Webhook $webhook): static
    {
        // set the URL awebhook call
        $this->url($webhook->url);

        // if the webhook has a secret, set it
        if (! is_null($webhook->secret)) {
            $this->useSecret($webhook->secret);
        }

        // set the webhook event model
        $this->webhook = $webhook;

        // done, return the instance of this class, so we can chain methods
        return $this;
    }

    /**
     * Set the webhook event model.
     *
     * @param  WebhookEvent  $webhookEvent The webhook event model
     * @return static                   The instance of this class, so we can chain methods
     */
    public function webhookEvent(WebhookEvent $webhookEvent): static
    {
        // set the webhook event model
        $this->webhookEvent = $webhookEvent;

        // done, return the instance of this class, so we can chain methods
        return $this;
    }

    /**
     * Set the entity the webhook call is linked to.
     *
     * @param  Model  $entity The entity
     * @return static                   The instance of this class, so we can chain methods
     */
    public function forEntity(Model $entity): static
    {
        // set the related entity
        $this->entity = $entity;

        // done, return the instance of this class, so we can chain methods
        return $this;
    }

    /**
     * Prepare for dispatch.
     *
     * @throws CouldNotCallWebhook
     */
    protected function prepareForDispatch(): void
    {
        // throw an exception if the webhook model is not set
        if (! isset($this->webhook)) {
            throw new CouldNotCallWebhook('Webhook model not set.');
        }

        // call the parent
        parent::prepareForDispatch();

        // add the webhook_id to the meta data
        $this->callWebhookJob->meta['webhook_id'] = $this->webhook->id;

        // if the webhook event model is set, add the webhook_event_id to the meta data
        if (isset($this->webhookEvent)) {
            $this->callWebhookJob->meta['webhook_event_id'] = $this->webhookEvent->id;
        }

        // if the entity is set, add the entity_id and entity_type to the meta data
        if (isset($this->entity)) {
            $this->callWebhookJob->meta['entity_id'] = $this->entity->id;
            $this->callWebhookJob->meta['entity_type'] = get_class($this->entity);
        }
    }
}
