<?php

namespace Weblab\WebhookCall\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Weblab\WebhookCall\Models\Webhook;
use Weblab\WebhookCall\Models\WebhookEvent;
use Weblab\WebhookCall\Models\WebhookLog;

class WebhookLogFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = WebhookLog::class;

    /**
     * The definition
     *
     * @return array                    The definition
     */
    public function definition()
    {
        return [
            'webhook_id' => Webhook::factory(),
            'webhook_event_id' => WebhookEvent::factory(),
            'event_name' => $this->faker->randomElement(['FinalWebhookCallFailedEvent', 'WebhookCallFailedEvent', 'WebhookCallSucceededEvent']),
            'http_verb' => $this->faker->randomElement(['GET', 'POST', 'PUT', 'PATCH', 'DELETE']),
            'payload' => $this->faker->randomElement([['foo' => 'bar'], ['foo' => 'bar', 'bar' => 'foo']]),
            'http_code' => 200,
            'response_body' => $this->faker->randomElement([['foo' => 'bar'], ['foo' => 'bar', 'bar' => 'foo']]),
        ];
    }
}
