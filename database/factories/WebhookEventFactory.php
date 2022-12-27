<?php

namespace Weblab\WebhookCall\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Weblab\WebhookCall\Models\WebhookEvent;

/**
 * Class WebhookEventFactory
 *
 * @extends Factory<WebhookEvent>
 */
class WebhookEventFactory extends Factory
{
    /**
     * @var class-string<WebhookEvent>
     */
    protected $model = WebhookEvent::class;

    /**
     * The definition
     *
     * @return array                    The definition
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->url,
        ];
    }
}
