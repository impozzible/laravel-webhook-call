<?php

namespace Weblab\WebhookCall\Exceptions;

class WebhookCallListenerException extends \Exception
{
    /**
     * Helper method to create a new instance of this class with a message set
     *
     * @return static               A new exception instance
     */
    public static function webhookNotSet(): static
    {
        return new static('Event could not be linked to a webhook because the webhook has not been set.');
    }

    /**
     * Helper method to create a new instance of this class with a message set
     *
     * @return static               A new exception instance
     */
    public static function webhookDoesNotExist(): static
    {
        return new static('Event could not be linked to a webhook because the webhook does not exist.');
    }
}
