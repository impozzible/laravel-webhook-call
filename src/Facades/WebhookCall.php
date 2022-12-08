<?php

namespace Weblab\WebhookCall\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Weblab\WebhookCall\WebhookCall
 */
class WebhookCall extends Facade
{
    /**
     * Get the facade accessor.
     *
     * @return string           The facade accessor
     */
    protected static function getFacadeAccessor()
    {
        return \Weblab\WebhookCall\WebhookCall::class;
    }
}
