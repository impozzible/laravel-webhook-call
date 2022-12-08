<?php

namespace Weblab\WebhookCall\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Webhook
 */
class Webhook extends Model
{
    use HasFactory;

    /**
     * Make all attributes fillable
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the webhook events (1 to many relationship with the WebhookEvent model through the webhook_webhook_events table)
     *
     * @return BelongsToMany                The webhook events statement
     */
    public function webhookEvents(): BelongsToMany
    {
        return $this->belongsToMany(WebhookEvent::class, 'webhook_webhook_events');
    }

    /**
     * Get the webhook logs for this webhook (1 to many relationship with the WebhookLog model)
     *
     * @return HasMany              The webhook logs statement
     */
    public function webhookLogs(): HasMany
    {
        return $this->hasMany(WebhookLog::class);
    }
}
