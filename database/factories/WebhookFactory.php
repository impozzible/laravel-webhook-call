<?php

namespace Weblab\WebhookCall\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Weblab\WebhookCall\Models\Webhook;


class WebhookFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Webhook::class;

    /**
     * The definition
     *
     * @return array                    The definition
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'url' => $this->faker->url,
            'secret' => $this->faker->password,
            'enabled' => 1,
        ];
    }
}
