<?php

return [
    // the model to use for the webhook calls
    'models' => [
        // The model that should be used to store the webhook endpoint data.
        'webhook' => \Weblab\WebhookCall\Models\Webhook::class,

        // The model that should be used to store the webhook event data.
        'webhook_event' => \Weblab\WebhookCall\Models\WebhookEvent::class,

        // The model that should be used to store the webhook log data.
        'webhook_log' => \Weblab\WebhookCall\Models\WebhookLog::class,
    ],
];
